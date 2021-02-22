<?php

namespace CertUnlp\NgenBundle\Entity\Incident\State\Behavior;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 *
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class DiscardedBehavior extends StateBehavior
{
    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'folder-minus';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'danger';
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
    public function isSolved(): bool
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

    public function isLive(): bool
    {
        return false;
    }

    public function isDead(): bool
    {
        return true;
    }

}
