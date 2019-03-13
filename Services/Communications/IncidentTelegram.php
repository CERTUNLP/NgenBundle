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
    /**
     * @param CommentPersistEvent $event
     */
    public function onCommentPrePersist(CommentPersistEvent $event): void
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

        return sprintf($formato, $this->getTelegramIcon($this->getPriority($incident)->getSlug()), $incident->getAddress(), $incident->getType()->getName(), $this->getPriority($incident)->getName(), $incident->getTlp()->getSlug(), $this->getTlpIcon($incident->getTlp()->getSlug()));
    }

    /**
     * @param string $priority
     * @return string
     */
    public function getTelegramIcon(string $priority): string
    {

        if ($priority === 'high') {
            $state = "\u{274C}";
        } elseif ($priority === 'warning') {
            $state = "\u{1F4A5}";
        } elseif ($priority === 'critical') {
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
