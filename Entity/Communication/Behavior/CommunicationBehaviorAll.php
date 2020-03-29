<?php

namespace CertUnlp\NgenBundle\Entity\Communication\Behavior;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class CommunicationBehaviorAll extends CommunicationBehavior
{

    public function getAllowedMethods(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function inversedBehavior(): bool
    {
        return true;
    }

    public function print(): ?string
    {
        return $this->getIncidentDetected()->getAssigned();
    }

    public function getFile(): ?string
    {
        return $this->getIncidentDetected()->getEvidenceFilePath();
    }
}
