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

class IncidentTelegram extends IncidentCommunication
{

    /**
     * @param Incident $incident
     * @return void
     */
    public function comunicate(Incident $incident): void
    {
        $telegrams = $this->getTelegramContacts($incident);
        if ($telegrams) {
            foreach ($telegrams as $telegram) {
                $message = new TelegramMessage();
                $message->setData($this->createDataJson($incident, $telegram));
                $message->setIncidentId($incident->getId());
                $message->setPending(true);
                $this->getDoctrine()->persist($message);
            }
            $this->getDoctrine()->flush();
        }
    }

    public function createDataJson(Incident $incident, Contact $contact)
    {
        $data = [];
        $data['type'] = $incident->getType()->getName();
        $data['address'] = $incident->getAddress();
        $data['state'] = $incident->getState()->getName();
        $data['tlp'] = $incident->getTlp()->getName();
        $data['date'] = $incident->getDate();
        $data['priority'] = $this->getPriority($incident)->getName();
        $credentials = explode('@', $contact->getUsername());
        $data['token'] = $credentials[0];
        $data['chatid'] = $credentials[1];

        return $data;


    }
}
