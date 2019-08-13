<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Network\Host\Listener;

use CertUnlp\NgenBundle\Entity\Network\Host\Host;
use CertUnlp\NgenBundle\Services\Api\Handler\HostHandler;
use CertUnlp\NgenBundle\Services\Api\Handler\NetworkHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use Gedmo\Sluggable\Util as Sluggable;
use Symfony\Component\Routing\Router;


class HostListener
{

    public $delegator_chain;
    private $network_handler;
    private $entityManager;
    private $thread_manager;
    private $router;
    private $host_handler;

    public function __construct(HostHandler $host_handler, NetworkHandler $network_handler, EntityManager $entityManager, ThreadManagerInterface $thread_manager, Router $router)
    {
        $this->host_handler = $host_handler;
        $this->network_handler = $network_handler;
        $this->entityManager = $entityManager;
        $this->thread_manager = $thread_manager;
        $this->router = $router;

    }

    /** @ORM\PostLoad()
     * @param Host $host
     * @param LifecycleEventArgs $event
     */
    public function postLoadHandler(Host $host, LifecycleEventArgs $event): void
    {
        $host->guessAddress($host->getIp() ?? $host->getDomain());
        $this->networkUpdate($host);

    }

    /**
     * @param Host $host
     */
    public function networkUpdate(Host $host): void
    {
        $network = $host->getNetwork();
        $network_new = $this->network_handler->getByHostAddress($host->getAddress());
        if ($network_new) {
            if ($network) {
                if (!$network->equals($network_new)) {
                    $host->setNetwork($network_new);
                }
            } else {
                $host->setNetwork($network_new);
            }
        }
    }

    /** @ORM\PrePersist
     * @param Host $host
     * @param LifecycleEventArgs $event
     */
    public function prePersistHandler(Host $host, LifecycleEventArgs $event): void
    {
        $host->guessAddress($host->getIp() ?? $host->getDomain());

        $this->incidentPrePersistUpdate($host, $event);
    }

    public function incidentPrePersistUpdate(Host $host, LifecycleEventArgs $event): void
    {
        $this->slugUpdate($host);
        $this->networkUpdate($host);
    }

    public function slugUpdate(Host $incident): void
    {
        $incident->setSlug(Sluggable\Urlizer::urlize($incident->getAddress()));
    }

    /** @ORM\PreUpdate
     * @param Host $host
     * @param PreUpdateEventArgs $event
     */
    public function preUpdateHandler(Host $host, PreUpdateEventArgs $event): void
    {
        $this->incidentPrePersistUpdate($host, $event);
    }

    /**
     * @param Host $host
     */
    public function commentThreadUpdate(Host $host): void
    {
        $id = $host->getId();
        $thread = $this->thread_manager->findThreadById($id);
        if (null === $thread) {
            $thread = $this->thread_manager->createThread();
            $thread->setId($id);
            $host->setCommentThread($thread);
            $thread->setIncident($host);
            $uri = $this->router->generate('cert_unlp_ngen_internal_incident_frontend_edit_incident', array(
                'slug' => $host->getSlug(),
            ));
            $thread->setPermalink($uri);

            // Add the thread
            $this->thread_manager->saveThread($thread);
        }
    }
}
