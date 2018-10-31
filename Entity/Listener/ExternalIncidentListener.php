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

use CertUnlp\NgenBundle\Model\IncidentInterface;
use CertUnlp\NgenBundle\Services\Delegator\DelegatorChain;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Sluggable\Util as Sluggable;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ExternalIncidentListener implements ContainerAwareInterface
{

    public $delegator_chain;
    private $container;

    public function __construct(DelegatorChain $delegator_chain, ContainerInterface $container)
    {
        $this->delegator_chain = $delegator_chain;
        $this->setContainer($container);
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /** @ORM\PrePersist
     * @param IncidentInterface $incident
     * @param LifecycleEventArgs $event
     */
    public function prePersistHandler(IncidentInterface $incident, LifecycleEventArgs $event)
    {
        $this->incidentPrePersistUpdate($incident, $event);

        $this->delegator_chain->prePersistDelegation($incident);
    }

    public function incidentPrePersistUpdate(IncidentInterface $incident, $event)
    {
        $this->timestampsUpdate($incident);
        $this->slugUpdate($incident);
        $this->stateUpdate($incident, $event);
        $this->feedUpdate($incident, $event);
    }

    public function timestampsUpdate($incident)
    {
        if ($incident->getDate() == null) {
            $incident->setDate(new \DateTime('now'));
        }
    }

    public function slugUpdate(IncidentInterface $incident)
    {
        $incident->setSlug(Sluggable\Urlizer::urlize($incident->getHostAddress() . " " . $incident->getType()->getSlug() . " " . $incident->getDate()->format('Y-m-d-H-i'), '_'));
    }

    public function stateUpdate(IncidentInterface $incident, $event)
    {
        $entityManager = $event->getEntityManager();
        $repository = $entityManager->getRepository('CertUnlpNgenBundle:IncidentState');
        $state = $incident->getState();
        $newState = $repository->findOneBySlug('open');
        if ($state == null) {
            $incident->setState($newState);
        }
    }

    public function feedUpdate(IncidentInterface $incident, $event)
    {
        $entityManager = $event->getEntityManager();
        $repository = $entityManager->getRepository('CertUnlpNgenBundle:IncidentFeed');
        $state = $incident->getFeed();
        $newState = $repository->findOneBySlug('cert_unlp');
        if ($state == null) {
            $incident->setFeed($newState);
        }
    }

    /** @ORM\PreUpdate
     * @param IncidentInterface $incident
     * @param PreUpdateEventArgs $event
     */
    public function preUpdateHandler(IncidentInterface $incident, PreUpdateEventArgs $event)
    {
        $this->incidentPrePersistUpdate($incident, $event);
        $this->delegator_chain->preUpdateDelegation($incident);
    }

    /** @ORM\PostPersist
     * @param IncidentInterface $incident
     * @param LifecycleEventArgs $event
     */
    public function postPersistHandler(IncidentInterface $incident, LifecycleEventArgs $event)
    {
        $this->delegator_chain->postPersistDelegation($incident);
        $this->commentThreadUpdate($incident, $event);
    }

    public function commentThreadUpdate(IncidentInterface $incident, $event)
    {
        $id = $incident->getId();
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $incident->setCommentThread($thread);
            $thread->setIncident($incident);
            $uri = $this->container->get('router')->generate('cert_unlp_ngen_external_incident_frontend_edit_incident', array(
                'slug' => $incident->getSlug(),
            ));
            $thread->setPermalink($uri);

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }
    }

    /** @ORM\PostUpdate
     * @param IncidentInterface $incident
     * @param LifecycleEventArgs $event
     */
    public function postUpdateHandler(IncidentInterface $incident, LifecycleEventArgs $event)
    {
        $this->delegator_chain->postUpdateDelegation($incident);
    }

}
