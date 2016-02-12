<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
//use Doctrine\ORM\Event\PreFlushEventArgs;
use CertUnlp\NgenBundle\Entity\Incident;
use Doctrine\ORM\Mapping as ORM;
use CertUnlp\NgenBundle\Services\Delegator\Delegator;
use CertUnlp\NgenBundle\Model\IncidentInterface;
use CertUnlp\NgenBundle\Event\ConvertToIncidentEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Gedmo\Sluggable\Util as Sluggable;

class IncidentListener implements ContainerAwareInterface {

    public $delegator;

    public function __construct(Delegator $delegator, ContainerInterface $container) {
        $this->delegator = $delegator;
        $this->setContainer($container);
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /** @ORM\PrePersist */
    public function prePersistHandler(IncidentInterface $incident, LifecycleEventArgs $event) {
        $this->incidentPostPersistUpdate($incident, $event);

        $this->delegator->prePersistDelegation($incident);
    }

    /** @ORM\PreUpdate */
    public function preUpdateHandler(Incident $incident, PreUpdateEventArgs $event) {
        $this->incidentPostPersistUpdate($incident, $event);
        $this->delegator->preUpdateDelegation($incident);
    }

//    
//    public function preFlushHandler(IncidentInterface $incident, PreFlushEventArgs $event) {
//        $this->delegator->preFlushDelegation($incident);
//    }

    public function onConvertToIncident(ConvertToIncidentEvent $event) {
        $convertible = $event->getConvertible();
        $entityManager = $this->container->get('doctrine')->getManager();
        $incidentType = $entityManager->getRepository('CertUnlpNgenBundle:IncidentType')->findOneBySlug($convertible->getType());
        $incidentFeed = $entityManager->getRepository('CertUnlpNgenBundle:IncidentFeed')->findOneBySlug($convertible->getFeed());
        if ($convertible->getReporter() == 'random') {

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
            'hostAddress' => $convertible->getHostAddress(),
            'evidence_file' => $UploadedFile,
            'sendReport' => true
        ];

        try {
            $this->container->get('cert_unlp.ngen.incident.handler')->post($parameters, false);
        } catch (InvalidFormException $exc) {
            return;
        }
    }

    /** @ORM\PostPersist */
    public function postPersistHandler(Incident $incident, LifecycleEventArgs $event) {
        $this->delegator->postPersistDelegation($incident);
        $this->commentThreadUpdate($incident, $event);
    }

    /** @ORM\PostUpdate */
    public function postUpdateHandler(Incident $incident, LifecycleEventArgs $event) {
        $this->delegator->postUpdateDelegation($incident);
    }

//
//    /** @PostRemove */
//    public function postRemoveHandler(Incident $incident, LifecycleEventArgs $event) {
//        
//    }
//
//    /** @PreRemove */
//    public function preRemoveHandler(Incident $incident, LifecycleEventArgs $event) {
//        
//    }
//
//
//    /** @PostLoad */
//    public function postLoadHandler(Incident $incident, LifecycleEventArgs $event) {
//        
//    }


    public function incidentPostPersistUpdate($incident, $event) {
        $this->timestampsUpdate($incident);
        $this->slugUpdate($incident);
        $this->networkUpdate($incident, $event);
        $this->stateUpdate($incident, $event);
        $this->feedUpdate($incident, $event);
    }

    public function commentThreadUpdate($incident, $event) {
        $id = $incident->getId();
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setIncident($incident);
            $uri = $this->container->get('router')->generate('cert_unlp_ngen_incident_edit_incident', array(
                'hostAddress' => $incident->getHostAddress(),
                'date' => $incident->getDate()->format('Y-m-d'),
                'type' => $incident->getType()->getSlug()
            ));
            $thread->setPermalink($uri);

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }
    }

    public function slugUpdate($incident) {
        $incident->setSlug(Sluggable\Urlizer::urlize($incident->getHostAddress() . " " . $incident->getType()->getSlug() . " " . $incident->getDate()->format('Y-m-d'), '_'));
    }

    public function networkUpdate($incident, $event) {
//        if (!$incident->isClosed()) {
        $entityManager = $event->getEntityManager();
        $network_handler = $this->container->get('cert_unlp.ngen.network.handler');
        $network = $incident->getNetwork();
        $newNetwork = $network_handler->getByHostAddress($incident->getHostAddress());
        if ($network != null && !$incident->isClosed()) {
            if (!$network->equals($newNetwork)) {
                $incident->setNetwork($newNetwork);
                $incident->setNetworkAdmin($newNetwork->getNetworkAdmin());
            }
        } else {
            $incident->setNetwork($newNetwork);
            $incident->setNetworkAdmin($newNetwork->getNetworkAdmin());
        }
//        }
    }

    public function stateUpdate($incident, $event) {
        $entityManager = $event->getEntityManager();
        $repository = $entityManager->getRepository('CertUnlpNgenBundle:IncidentState');
        $state = $incident->getState();
        $newState = $repository->findOneBySlug('open');
        if ($state == null) {
            $incident->setState($newState);
        }
    }

    public function feedUpdate($incident, $event) {
        $entityManager = $event->getEntityManager();
        $repository = $entityManager->getRepository('CertUnlpNgenBundle:IncidentFeed');
        $state = $incident->getFeed();
        $newState = $repository->findOneBySlug('cert_unlp');
        if ($state == null) {
            $incident->setFeed($newState);
        }
    }

    public function timestampsUpdate($incident) {
        if ($incident->getDate() == null) {
            $incident->setDate(new \DateTime('now'));
        }
    }

}
