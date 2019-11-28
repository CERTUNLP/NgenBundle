<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident\Report;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use CertUnlp\NgenBundle\Entity\Incident\Report\IncidentReport;

/**
 * OpenIncidentReport
 *
 */


class OpenIncidentReport extends \CertUnlp\NgenBundle\Entity\Incident\Report\IncidentReport
{

    private $cain="Open";

    /**
     * @return string
     */
    public function getCain(): string
    {
        return $this->cain;
    }

    /**
     * @param string $cain
     */
    public function setCain(string $cain): void
    {
        $this->cain = $cain;
    }
}
