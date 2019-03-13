<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Communications;

use CertUnlp\NgenBundle\Entity\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\TelegramMessage;
use FOS\CommentBundle\Event\CommentPersistEvent;
use FOS\CommentBundle\Model\SignedCommentInterface;

class IncidentTelegram extends IncidentCommunication
{
    public function onCommentPrePersist(CommentPersistEvent $event)
    {
        $comment = $event->getComment();

        if (!$this->commentManager->isNewComment($comment)) {
            return;
        }
        if ($comment instanceof SignedCommentInterface) {
            $author = $comment->getAuthor();
            if ($author->getUsername() === 'mailbot') {
                return;
            }
        }
        $this->comunicate($comment->getThread()->getIncident(), $comment->getBody(), $comment->getNotifyToAdmin());
    }


    /**
     * @param Incident $incident
     * @param string $body
     * @param bool $notify_to_admins
     * @return void
     */
    public function comunicate(Incident $incident, string $body = '', bool $notify_to_admins = true): void
    {
        if ($notify_to_admins) {
            $telegrams = $this->getTelegramContacts($incident);
            if ($telegrams) {
                foreach ($telegrams as $telegram) {
                    $message = new TelegramMessage();
                    $message->setData($this->createDataJson($incident, $telegram, $body));
                    $message->setIncidentId($incident->getId());
                    $message->setPending(true);
                    $this->getDoctrine()->persist($message);
                }
                $this->getDoctrine()->flush();
            }
        }
    }

    public function createDataJson(Incident $incident, Contact $contact, string $notes = '')
    {
        $data = [];
        $data['type'] = $incident->getType()->getName();
        $data['address'] = $incident->getAddress();
        $data['state'] = $incident->getState()->getName();
        $data['tlp'] = $incident->getTlp()->getName();
        $data['date'] = $incident->getDate();
        $data['priority'] = $this->getPriority($incident)->getName();
        $data['notes'] = $notes ?? $incident->getNotes();
        $credentials = explode('@', $contact->getUsername());
        $data['token'] = $credentials[0];
        $data['chatid'] = $credentials[1];

        return $data;


    }
}
