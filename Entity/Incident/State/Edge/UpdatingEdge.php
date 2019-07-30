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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

//use Doctrine\Common\Collections\Collection;

/**
 * IncidentType
 *
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class UpdatingEdge extends StateEdge
{
    /**
     * @return bool
     */
    public function isOpening(): bool
    {
        return false;
    }


    /**
     * @return bool
     */
    public function isClosing(): bool
    {

        return false;
    }

    /**
     * @return bool
     */
    public function isReopening(): bool
    {
        return false;
    }


    /**
     * @return bool
     */
    public function isUpdating(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isDiscarding(): bool
    {
        return false;
    }

    /**
     * @param Incident $incident
     * @return Incident
     */
    public function changeIncidentStateAction(Incident $incident): Incident
    {
        return $incident;
    }
}
