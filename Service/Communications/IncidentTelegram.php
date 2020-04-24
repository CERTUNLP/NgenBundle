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

use CertUnlp\NgenBundle\Entity\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Communication\TelegramMessage;
use FOS\CommentBundle\Event\CommentPersistEvent;
use FOS\CommentBundle\Model\SignedCommentInterface;

class IncidentTelegram extends IncidentCommunication
{
    /**
     * @param CommentPersistEvent $event
     */
    public function onCommentPrePersist(CommentPersistEvent $event): void
    {
        $comment = $event->getComment();

        if (!$this->commentManager->isNewComment($comment) || !$comment->getThread()->getIncident()->canCommunicateComment()) {
            return;
        }
        if ($comment instanceof SignedCommentInterface) {
            $author = $comment->getAuthor();
            if ($author->getUserName() === 'mailbot') {
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
            $telegrams = $incident->getTelegramContacts();
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

    /**
     * @param Incident $incident
     * @param Contact $contact
     * @param string $notes
     * @return array
     */
    public function createDataJson(Incident $incident, Contact $contact, string $notes = ''): array
    {
        $data = [];
        $data['message'] = $this->getMessage($incident, $notes);
        $credentials = explode('@', $contact->getUsername());
        $data['token'] = $credentials[0];
        $data['chatid'] = $credentials[1];

        return $data;
    }

    /**
     * @param Incident $incident
     * @param string $notes
     * @return string
     */
    public function getMessage(Incident $incident, string $notes = ''): string
    {
        $formato = $this->translator->trans('telegram_message');
        $comment = $notes ?? $incident->getNotes();
        if ($comment) {
            $formato .= sprintf(PHP_EOL . PHP_EOL . '*' . $this->translator->trans('Note/Comment') . ':*  %s', $notes ?? $incident->getNotes());
        }

        return sprintf($formato, $this->getTelegramIcon($incident->getPriority()->getSlug()), $incident->getAddress(), $incident->getType()->getName(), $incident->getPriority()->getName(), $incident->getTlp()->getSlug(), $this->getTlpIcon($incident->getTlp()->getSlug()));
    }

    /**
     * @param string $priority
     * @return string
     */
    public function getTelegramIcon(string $priority): string
    {

        if ($priority === 'Critical') {
            $state = "\u{274C}";
        } elseif ($priority === 'High') {
            $state = "\u{1F534}";
        } elseif ($priority === 'Medium') {
            $state = "\u{1F525}";
        } elseif ($priority === 'Low') {
            $state = "\u{2733}";
        } elseif ($priority === 'Very Low') {
            $state = "\u{1F525}";
        } else {
            $state = "\u{2753}";
        }
        return $state;
    }

    /**
     * @param string $tlp
     * @return string
     */
    public function getTlpIcon(string $tlp): string
    {

        if ($tlp === 'red') {
            $state = "\u{26D4}";
        } elseif ($tlp === 'amber') {
            $state = "\u{26A0}";
        } elseif ($tlp === 'green') {
            $state = "\u{267B}";
        } else {
            $state = "\u{26AA}";
        }
        return $state;
    }
}
