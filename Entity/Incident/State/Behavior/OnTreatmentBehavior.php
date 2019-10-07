<?php

namespace CertUnlp\NgenBundle\Entity\Incident\State\Behavior;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;


/**
 *
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class OnTreatmentBehavior extends StateBehavior
{
    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'folder-open';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'info';
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
        return false;
    }

    /**
     * @return bool
     */
    public function isAddressed(): bool
    {
        return true;
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
