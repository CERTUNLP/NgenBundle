<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Entity;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Service\Delegator\DelegatorChain;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use Symfony\Component\Routing\Router;


class IncidentListener
{
    /**
     * @var DelegatorChain
     */
    private $delegator_chain;
    /**
     * @var ThreadManagerInterface
     */
    private $thread_manager;
    /**
     * @var Router
     */
    private $router;

    /**
     * IncidentListener constructor.
     * @param DelegatorChain $delegator_chain
     * @param ThreadManagerInterface $thread_manager
     * @param Router $router
     */
    public function __construct(DelegatorChain $delegator_chain, ThreadManagerInterface $thread_manager, Router $router)
    {

        $this->delegator_chain = $delegator_chain;
        $this->thread_manager = $thread_manager;
        $this->router = $router;

    }

    /**
     * @ORM\PrePersist
     * @param Incident $incident
     */
    public function prePersistHandler(Incident $incident): void
    {
        $this->getDelegatorChain()->prePersistDelegation($incident);
    }

    /**
     * @return DelegatorChain
     */
    public function getDelegatorChain(): DelegatorChain
    {
        return $this->delegator_chain;
    }

    /** @ORM\PostPersist
     * @param Incident $incident
     */
    public function postPersistHandler(Incident $incident): void
    {
        $this->getDelegatorChain()->postPersistDelegation($incident);
        $this->commentThreadUpdate($incident);
    }

    /**
     * @param Incident $incident
     */
    public function commentThreadUpdate(Incident $incident): void
    {
        $id = $incident->getId();
        $thread = $this->getThreadManager()->findThreadById($id);
        if (null === $thread) {
            $thread = $this->getThreadManager()->createThread();
            $thread->setId($id);
            $incident->setCommentThread($thread);
            $thread->setIncident($incident);
            $uri = $this->getRouter()->generate('cert_unlp_ngen_internal_incident_frontend_edit_incident', array(
                'slug' => $incident->getSlug(),
            ));
            $thread->setPermalink($uri);

            // Add the thread
            $this->getThreadManager()->saveThread($thread);
        }
    }

    /**
     * @return ThreadManagerInterface
     */
    public function getThreadManager(): ThreadManagerInterface
    {
        return $this->thread_manager;
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @ORM\PostUpdate
     * @param Incident $incident
     */
    public function postUpdateHandler(Incident $incident): void
    {
        $this->getDelegatorChain()->postUpdateDelegation($incident);
    }


}
