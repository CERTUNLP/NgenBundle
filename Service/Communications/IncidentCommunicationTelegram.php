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
use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactTelegram;
use CertUnlp\NgenBundle\Entity\Communication\Message\Message;
use CertUnlp\NgenBundle\Entity\Communication\Message\MessageTelegram;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Doctrine\Common\Collections\ArrayCollection;

class IncidentCommunicationTelegram extends IncidentCommunication
{

    /**
     * @param Incident $incident
     * @return ArrayCollection|ContactTelegram[]
     */
    public function getContacts(Incident $incident): ArrayCollection
    {
        return $incident->getTelegramContacts();
    }

    /**
     * @return Message
     */
    public function createMessage(): Message
    {
        return new MessageTelegram();
    }

    /**
     * @param Incident $incident
     * @param Contact|null $contact
     * @return array
     */
    public function createDataJson(Incident $incident, ?Contact $contact): array
    {
        $data = parent::createDataJson($incident, $contact);
        if ($contact) {
            $credentials = explode('@', $contact->getUsername());
            $data['token'] = $credentials[0];
            $data['chatid'] = $credentials[1];
        }
        return $data;
    }

    /**
     * @param Incident $incident
     * @return string
     */
    public function getDataMessage(Incident $incident): string
    {
        $formato = $this->getTranslator()->trans('telegram_message');
        $comment = $incident->getNotes();
        if ($comment) {
            $formato .= sprintf(PHP_EOL . PHP_EOL . '*' . $this->getTranslator()->trans('Note/Comment') . ':*  %s', $comment);
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
