<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Communications;

use CertUnlp\NgenBundle\Entity\Communication\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Communication\Message\Message;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CommentBundle\Event\CommentPersistEvent;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Component\Translation\TranslatorInterface;

abstract class IncidentCommunication
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;
    /**
     * @var CommentManagerInterface
     */
    private $commentManager;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(EntityManagerInterface $doctrine, CommentManagerInterface $commentManager, TranslatorInterface $translator)
    {
        $this->doctrine = $doctrine;
        $this->commentManager = $commentManager;
        $this->translator = $translator;
    }

    /**
     * @param CommentPersistEvent $event
     */
    public function onCommentPrePersist(CommentPersistEvent $event): void
    {
        $comment = $event->getComment();
        if (!$this->getCommentManager()->isNewComment($comment) || !$comment->getThread()->getIncident()->canCommunicateComment()) {
            return;
        }
        if ($comment instanceof SignedCommentInterface) {
            $author = $comment->getAuthor();
            if ($author->getUserName() === 'mailbot') {
                return;
            }
        }
        $this->comunicate_reply($comment->getThread()->getIncident(), $comment->getBody(), $comment->getNotifyToAdmin());
    }

    /**
     * @return CommentManagerInterface
     */
    public function getCommentManager(): CommentManagerInterface
    {
        return $this->commentManager;
    }

    /**
     * @param Incident $incident
     * @param string $body
     * @param bool $notify_to_admins
     * @return void
     */
    public function comunicate_reply(Incident $incident, string $body = '', bool $notify_to_admins = true)
    {
//        if ($notify_to_admins) {
//            $contacts = $this->getContacts($incident);
//            if ($contacts) {
//                foreach ($contacts as $contact) {
//                    $message = $this->createMessage();
//                    $message->setData($this->createDataJson($incident, $contact));
//                    $message->setIncident($incident);
//                    $message->setPending(true);
//                    $this->getDoctrine()->persist($message);
//                }
//                $this->getDoctrine()->flush();
//            }
//        }
    }

    /**
     * @param Incident $incident
     */
    public function postPersistDelegation(Incident $incident): void
    {
        if ($incident->canCommunicate()) {
            $this->comunicate($incident);
        }
    }

    /**
     * @param Incident $incident
     * @return void
     */
    public function comunicate(Incident $incident): void
    {
        $contacts = $this->getContacts($incident);
        if ($contacts) {
            foreach ($contacts as $contact) {
                $message = $this->createMessage();
                $message->setData($this->createDataJson($incident, $contact));
                $message->setIncident($incident);
                $message->setPending(true);
                $this->getDoctrine()->persist($message);
            }
            $this->getDoctrine()->flush();
        }
    }

    /**
     * @param Incident $incident
     * @return ArrayCollection| Contact[]
     */
    abstract public function getContacts(Incident $incident): ArrayCollection;

    /**
     * @return Message
     */
    abstract public function createMessage(): Message;

    /**
     * @param Incident $incident
     * @param Contact|null $contact
     * @return array
     */
    public function createDataJson(Incident $incident, ?Contact $contact): array
    {
        $data['message'] = $this->getDataMessage($incident);
        return $data;
    }

    /**
     * @param Incident $incident
     * @return string
     */
    abstract public function getDataMessage(Incident $incident): string;

    /**
     * @return EntityManagerInterface
     */
    public function getDoctrine(): EntityManagerInterface
    {
        return $this->doctrine;
    }

    /**
     * @param Incident $incident
     */
    public function postUpdateDelegation(Incident $incident): void
    {
        if ($incident->canCommunicate()) {
            $this->comunicate($incident);
        }
    }

    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

}
