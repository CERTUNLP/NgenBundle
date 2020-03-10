<?php

namespace CertUnlp\NgenBundle\Entity\Communication\Behavior;

use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class CommunicationBehaviorAll extends CommunicationBehavior
{


    public function print(IncidentDetected $incidentDetected): ?string
    {
        return $incidentDetected->getAssigned();
    }

    public function getFile(IncidentDetected $incidentDetected): ?string
    {
        return $incidentDetected->getEvidenceFile();
    }
}
