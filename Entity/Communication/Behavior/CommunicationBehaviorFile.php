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


    public function getAllowedMethods(): array
    {
        return ['getEvidenceFilePath'];
    }

    /**
     * @inheritDoc
     */
    public function inversedBehavior(): bool
    {
        return false;
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
