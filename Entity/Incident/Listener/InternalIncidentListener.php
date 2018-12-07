<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident\Listener;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Event\ConvertToIncidentEvent;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use CertUnlp\NgenBundle\Services\Api\Handler\HostHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\IncidentHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\NetworkHandler;
use CertUnlp\NgenBundle\Services\Delegator\DelegatorChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use Gedmo\Sluggable\Util as Sluggable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Router;


class InternalIncidentListener
{

    public $delegator_chain;
    private $network_handler;
    private $incident_handler;
    private $entityManager;
    private $thread_manager;
    private $router;
    private $host_handler;

    public function __construct(DelegatorChain $delegator_chain, NetworkHandler $network_handler, IncidentHandler $incident_handler, EntityManager $entityManager, ThreadManagerInterface $thread_manager, Router $router)
    {
        $this->delegator_chain = $delegator_chain;
        $this->network_handler = $network_handler;
        $this->incident_handler = $incident_handler;
        $this->entityManager = $entityManager;
        $this->thread_manager = $thread_manager;
        $this->router = $router;

    }

    /** @ORM\PrePersist
     * @param Incident $incident
     * @param LifecycleEventArgs $event
     */
    public function prePersistHandler(Incident $incident, LifecycleEventArgs $event)
    {
        $this->incidentPrePersistUpdate($incident, $event);

        $this->delegator_chain->prePersistDelegation($incident);
    }

    public function incidentPrePersistUpdate(Incident $incident, LifecycleEventArgs $event)
    {
        $this->timestampsUpdate($incident);
        $this->networkUpdate($incident);
        $this->slugUpdate($incident);
        $this->stateUpdate($incident, $event);
        $this->feedUpdate($incident, $event);
        $this->tlpUpdate($incident, $event);
    }

    public function timestampsUpdate(Incident $incident): void
    {
        if ($incident->getDate() == null) {
            try {
                $incident->setDate(new \DateTime('now'));
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * @param Incident $incident
     */
    public function networkUpdate(Incident $incident): void
    {
        $network = $incident->getNetwork();
        $network_new = $incident->getOrigin()->getNetwork();
        if ($network) {
            if (!$network->equals($network_new) && !$incident->isClosed()) {
                $incident->setNetwork($network_new);
            }
        } else {
            $incident->setNetwork($network_new);
        }
    }

    /**
     * @param Incident $incident
     */
    public function slugUpdate(Incident $incident): void
    {
        $incident->setSlug(Sluggable\Urlizer::urlize($incident->getOrigin() . ' ' . $incident->getType()->getSlug() . ' ' . $incident->getDate()->format('Y-m-d-H-i'), '_'));
    }

    public function stateUpdate(Incident $incident, LifecycleEventArgs $event): void
    {
        $entityManager = $event->getEntityManager();
        $repository = $entityManager->getRepository('CertUnlpNgenBundle:Incident\IncidentState');
        $state = $incident->getState();
        $newState = $repository->findOneBySlug('open');
        if ($state === null) {
            $incident->setState($newState);
        }
    }

    public function feedUpdate(Incident $incident, LifecycleEventArgs $event): void
    {
        $entityManager = $event->getEntityManager();
        $repository = $entityManager->getRepository('CertUnlpNgenBundle:Incident\IncidentFeed');
        $state = $incident->getFeed();
        $newState = $repository->findOneBySlug('cert_unlp');
        if ($state === null) {
            $incident->setFeed($newState);
        }
    }

    public function tlpUpdate(Incident $incident, LifecycleEventArgs $event): void
    {
        #fix esto tiene que ir a INciddntDecision
        $entityManager = $event->getEntityManager();
        $repository = $entityManager->getRepository('CertUnlpNgenBundle:Incident\IncidentTlp');
        $tlp = $incident->getTlp();
        $newTLP = $repository->findOneBySlug('white');
        if ($tlp == null) {
            $incident->setTlp($newTLP);
        }
    }

    /**
     * @return HostHandler
     */
    public function getHostHandler(): HostHandler
    {
        return $this->host_handler;
    }

    /**
     * @param HostHandler $host_handler
     */
    public function setHostHandler(HostHandler $host_handler): void
    {
        $this->host_handler = $host_handler;
    }

    /** @ORM\PreUpdate
     * @param Incident $incident
     * @param PreUpdateEventArgs $event
     */
    public function preUpdateHandler(Incident $incident, PreUpdateEventArgs $event): void
    {
        $this->incidentPrePersistUpdate($incident, $event);
        $this->delegator_chain->preUpdateDelegation($incident);
    }

    public function onConvertToIncident(ConvertToIncidentEvent $event)
    {
        $convertible = $event->getConvertible();
        $entityManager = $this->entityManager;
        $incidentType = $entityManager->getRepository('CertUnlpNgenBundle:IncidentType')->findOneBySlug($convertible->getType());
        $incidentFeed = $entityManager->getRepository('CertUnlpNgenBundle:IncidentFeed')->findOneBySlug($convertible->getFeed());

        if ($convertible->getReporter() === 'random') {
            $incidentReporter = $entityManager->getRepository('CertUnlpNgenBundle:User')->findOneRandom();
        } else {
            $incidentReporter = $entityManager->getRepository('CertUnlpNgenBundle:User')->findOneBySlug($convertible->getReporter());
        }

        if (!$incidentType || !$incidentFeed || !$incidentReporter) {
            return;
        }

        $UploadedFile = new File(realpath($convertible->getEvidenceFile()));

        $parameters = [
            'type' => $convertible->getType(),
            'feed' => $convertible->getFeed(),
            'reporter' => $incidentReporter->getId(),
            'ip' => $convertible->getIp(),
            'evidence_file' => $UploadedFile,
            'sendReport' => true
        ];

        try {
            $this->incident_handler->post($parameters, false);
        } catch (InvalidFormException $exc) {
            return;
        }
    }

    /** @ORM\PostPersist
     * @param Incident $incident
     * @param LifecycleEventArgs $event
     */
    public function postPersistHandler(Incident $incident, LifecycleEventArgs $event): void
    {
        $this->delegator_chain->postPersistDelegation($incident);
        $this->commentThreadUpdate($incident, $event);
    }

    /**
     * @param Incident $incident
     */
    public function commentThreadUpdate(Incident $incident): void
    {
        $id = $incident->getId();
        $thread = $this->thread_manager->findThreadById($id);
        if (null === $thread) {
            $thread = $this->thread_manager->createThread();
            $thread->setId($id);
            $incident->setCommentThread($thread);
            $thread->setIncident($incident);
            $uri = $this->router->generate('cert_unlp_ngen_internal_incident_frontend_edit_incident', array(
                'slug' => $incident->getSlug(),
            ));
            $thread->setPermalink($uri);

            // Add the thread
            $this->thread_manager->saveThread($thread);
        }
    }

    /** @ORM\PostUpdate
     * @param Incident $incident
     */
    public function postUpdateHandler(Incident $incident): void
    {
        $this->delegator_chain->postUpdateDelegation($incident);
    }

}
