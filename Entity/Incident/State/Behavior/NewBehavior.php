<?php

namespace CertUnlp\NgenBundle\Entity\Incident\State\Behavior;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use JMS\Serializer\Annotation as JMS;


/**
 *
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class NewBehavior extends StateBehavior
{


    public function updateTlp(Incident $incident, Incident $incidentDetected): Incident
    {
        if ($incident->getTlp()->getCode() < $incidentDetected->getTlp()->getCode()) {
            $incident->setTlp($incidentDetected->getTlp());
        }
        return $incident;
    }


    public function updatePriority(Incident $incident, Incident $incidentDetected): Incident
    {
        if ($incident->getPriority()->getCode() > $incidentDetected->getPriority()->getCode()) {
            $incident->setPriority($incidentDetected->getPriority());
        }
        return $incident;
    }

    /**
     * @param Incident $incident
     * @return int
     * @throws Exception
     */
    public function getNewMinutes(Incident $incident): int
    {
        return $incident->getDate()->diff(new DateTime())->i; //lo devuelvo en minutos eso es el i
    }

    /**
     * @return bool
     */
    public function isAttended(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isResolved(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isAddressed(): bool
    {
        return false;
    }

    public function isLive(): bool
    {
        return true;
    }

    public function isDead(): bool
    {
        return false;
    }

}
