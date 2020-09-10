<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;
use FOS\CommentBundle\Entity\Thread;
use FOS\CommentBundle\Model\SignedCommentInterface;
use FOS\CommentBundle\Model\ThreadInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class IncidentComment extends BaseComment implements SignedCommentInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * Thread of this comment
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentCommentThread")
     */
    protected $thread;


    /**
     * Author of the comment
     *
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User\User")
     */
    private $author = null;
    /**
     * @var boolean
     */
    private $notify_to_admin = false;

    /**
     * {@inheritDoc}
     */
    public function getAuthorName(): string
    {
        if (null === $this->getAuthor()) {
            return 'Anonymous';
        }

        return $this->getAuthor()->getUsername();
    }

    /**
     * @return User|UserInterface
     */
    public function getAuthor(): ?UserInterface
    {
        return $this->author;
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthor(UserInterface $author): IncidentComment
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Set thread
     *
     * @param ThreadInterface $thread
     * @return IncidentComment
     */
    public function setThread(ThreadInterface $thread = null): IncidentComment
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * @return bool
     */
    public function getNotifyToAdmin(): bool
    {
        return $this->notify_to_admin;
    }

    /**
     * @param $notify_to_admin
     * @return $this
     */
    public function setNotifyToAdmin(bool $notify_to_admin): IncidentComment
    {
        $this->notify_to_admin = $notify_to_admin;
        return $this;
    }


}
