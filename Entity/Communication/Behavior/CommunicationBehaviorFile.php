<?php

namespace CertUnlp\NgenBundle\Entity\Communication\Behavior;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class CommunicationBehaviorFile extends CommunicationBehavior
{

    public function __construct(array $allowedMethods = [], bool $inversedBehavior = false)
    {
        parent::__construct(['getEvidenceFilePath'], $inversedBehavior);

    }

    public function print(): ?string
    {
        return '';
    }

    public function getFile(): ?string
    {
        return $this->getIncidentDetected()->getEvidenceFilePath();
    }
}
