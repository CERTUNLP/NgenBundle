<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentCommentThread")
     */
    protected $thread;

    /**
     * @var boolean
     */
    protected $notify_to_admin;

    /**
     * Author of the comment
     *
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User")
     * @var User
     */
    protected $author;

    public function getAuthorName()
    {
        if (null === $this->getAuthor()) {
            return 'Anonymous';
        }

        return $this->getAuthor()->getUsername();
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(UserInterface $author)
    {
        $this->author = $author;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get thread
     *
     * @return Thread
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set thread
     *
     * @param ThreadInterface $thread
     * @return IncidentComment
     */
    public function setThread(ThreadInterface $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get notify_to_admin
     *
     * @return boolean
     */
    public function getNotifyToAdmin()
    {
        return $this->notify_to_admin;
    }

    /**
     * Set notify_to_admin
     *
     * @param boolean $notifyToAdmin
     * @return IncidentComment
     */
    public function setNotifyToAdmin($notifyToAdmin)
    {
        $this->notify_to_admin = $notifyToAdmin;

        return $this;
    }

}
