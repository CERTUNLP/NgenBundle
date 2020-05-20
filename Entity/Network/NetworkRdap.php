<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Entity\Network;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class NetworkRdap extends Network
{
    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'project-diagram';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'primary';
    }

    public function isInternal(): bool
    {
        return false;
    }
}
