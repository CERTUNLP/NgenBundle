<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Address;

use JMS\Serializer\Annotation as JMS;

/**
 *
 * @JMS\ExclusionPolicy("all")
 */
class IpV4Address extends IpAddress
{

    /**
     * {@inheritDoc}
     */
    public function getCustomNumericAddress(): string
    {
        return ip2long($this->getCustomAddress());
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomNumericAddressMask(): int
    {
        return 0xffffffff << (32 - $this->getCustomAddress());
    }


    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return 'ip_v4';
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultIpMask(): int
    {
        return 32;
    }
}
