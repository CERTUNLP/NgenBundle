<?php

namespace CertUnlp\NgenBundle\Entity\Incident\State\Behavior;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use JMS\Serializer\Annotation as JMS;


/**
 *
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class OnTreatmentBehavior extends StateBehavior
{

    /**
     * @param Incident $incident
     * @return int
     * @throws Exception
     */
    public function getResolutionMinutes(Incident $incident): int
    {
//        if (!$this->isClosed()) {
//            if (!$this->isNew()) {
//                return abs(((new DateTime())->getTimestamp() - $incident->getOpenedAt()->getTimestamp()) / 60); //lo devuelvo en minutos eso es el i
//            }
//
//            return 0;
//        }
        if ($incident->getOpenedAt()) {
            return abs(($incident->getUpdatedAt()->getTimestamp() - $incident->getOpenedAt()->getTimestamp()) / 60);
        }
        return 0;

    }


    public function updateTlp(Incident $incident, Incident $incidentDetected): Incident
    {

        return $incident;
    }

    /**
     * @param Incident $incident
     * @return int
     * @throws Exception
     */
    public function getResponseMinutes(Incident $incident): int
    {
        if ($incident->getOpenedAt()) {
            return abs(($incident->getDate()->getTimestamp() - $incident->getOpenedAt()->getTimestamp()) / 60); //lo devuelvo en minutos eso es el i
        }
        return 0;

    }

    public function updatePriority(Incident $incident, Incident $incidentDetected): Incident
    {
        return $incident;
    }

    /**
     * @param Incident $incident
     * @return int
     * @throws Exception
     */
    public function getNewMinutes(Incident $incident): int
    {
        return 0;
    }

    /**
     * @return bool
     */
    public function isNew(): ?bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isClosed(): ?bool
    {
        return false;
    }
}
