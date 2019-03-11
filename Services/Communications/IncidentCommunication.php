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
use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

abstract class IncidentCommunication
{

    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function postPersistDelegation($incident)
    {
        $this->comunicate($incident);
    }

    abstract public function comunicate(Incident $incident): void;

    /**
     * @param Incident $incident
     * @return array
     */
    public function getEmails(Incident $incident): array
    {
        return array_filter($this->getEmailContacts($incident)->map(function (Contact $contact) {
            return $contact->getEmail();
        })->toArray(), function ($value) {
            return $value !== '';
        });
    }

    /**
     * @param Incident $incident
     * @return ArrayCollection
     */
    public function getEmailContacts(Incident $incident): ArrayCollection
    {
        return $this->getContacts($incident)->filter(function (Contact $contact) {
            return $contact->getEmail();
        });
    }

    /**
     * @param $incident
     * @return ArrayCollection
     */
    public function getContacts(Incident $incident): ArrayCollection
    {
        $incidentContacts = $incident->getContacts();
//            if ($this->teamContact) {
//                $incidentContacts->add($this->teamContact);
//            }
        $priorityCode = $this->getPriorityCode($incident);
        return $incidentContacts->filter(function (Contact $contact) use ($priorityCode) {
            return $contact->getContactCase()->getLevel() >= $priorityCode;
        });
    }

    /**
     * @param Incident $incident
     * @return int
     */
    public function getPriorityCode(Incident $incident): int
    {
        $priority = $this->getPriority($incident);
        return $priority ? $priority->getCode() : 5;
    }

    /**
     * @param Incident $incident
     * @return IncidentPriority
     */
    public function getPriority(Incident $incident): IncidentPriority
    {
        $repo = $this->getDoctrine()->getRepository(IncidentPriority::class);
        $priority = $repo->findOneBy(array('impact' => $incident->getImpact()->getSlug(), 'urgency' => $incident->getUrgency()->getSlug()));
        return $priority;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getDoctrine(): EntityManagerInterface
    {
        return $this->doctrine;
    }

    /**
     * @param Incident $incident
     * @return array
     */
    public function getTelegrams(Incident $incident): array
    {
        return array_filter($this->getTelegramContacts($incident)->map(function (Contact $contact) {
            return $contact->getTelegram();
        })->toArray(), function ($value) {
            return $value !== '';
        });
    }

    /**
     * @param Incident $incident
     * @return ArrayCollection
     */
    public function getTelegramContacts(Incident $incident): ArrayCollection
    {
        return $this->getContacts($incident)->filter(function (Contact $contact) {
            return $contact->getTelegram();
        });
    }
}
