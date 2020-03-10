<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident\State\Edge;

use CertUnlp\NgenBundle\Entity\Communication\Behavior\CommunicationBehavior;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

//use Doctrine\Common\Collections\Collection;

/**
 * IncidentType
 *
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class ClosingEdge extends StateEdge
{

    public function changeIncidentStateAction(Incident $incident): Incident
    {
        $incident->setNeedToCommunicate(true);
        return $incident;
    }

    public function getIncidentsDetectedCommunicationBehavior(IncidentDetected $incidentDetected): CommunicationBehavior
    {
        return $incidentDetected->getCommunicationBehaviorClose()->setIncidentDetected($incidentDetected);
    }
}
