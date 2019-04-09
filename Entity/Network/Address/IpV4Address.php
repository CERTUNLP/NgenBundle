<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Network\Address;

use JMS\Serializer\Annotation as JMS;

/**
 *
 * @JMS\ExclusionPolicy("all")
 */
class IpV4Address extends IpAddress
{

    public function getCustomNumericAddress(): string
    {
        return ip2long($this->getCustomAddress());
    }


    public function getCustomNumericAddressMask(): string
    {
        return 0xffffffff << (32 - $this->getCustomAddress());
    }


    public function getType(): string
    {
        return 'ip_v4';
    }

    public function getDefaultIpMask(): int
    {
        return 32;
    }
}
