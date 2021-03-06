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
    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'file';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'primary';
    }

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
     * @return bool
     */
    public function isAttended(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isSolved(): bool
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
