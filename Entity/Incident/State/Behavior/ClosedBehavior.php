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
class ClosedBehavior extends StateBehavior
{
    /**
     * @param Incident $incident
     * @return int
     * @throws Exception
     */
    public function getResolutionMinutes(Incident $incident): int
    {
        return abs(($incident->getUpdatedAt()->getTimestamp() - $incident->getOpenedAt()->getTimestamp()) / 60);
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
        return abs(((new DateTime())->getTimestamp() - $incident->getDate()->getTimestamp()) / 60);
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
    public function isAttended(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isResolved(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isAddressed(): bool
    {
        return false;
    }
}
