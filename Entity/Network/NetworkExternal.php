<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Network;

use Doctrine\ORM\Mapping as ORM;

/**
 * Network
 *
 * @author dam
 * @ORM\Entity()
 */
class NetworkExternal extends Network
{

    public function isInternal(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'share-alt';
    }
}
