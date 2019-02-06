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

use CertUnlp\NgenBundle\Entity\Network\Network;
use JMS\Serializer\Annotation as JMS;

/**
 *
 * @JMS\ExclusionPolicy("all")
 */
class IpV4Address extends Address
{
    public function setCustomAddress(string $address): Network
    {
        $ip_and_mask = explode('/', $address);
        $this->getNetwork()->setIpV4($ip_and_mask[0]);
        $this->setCustomNumericAddress($ip_and_mask[0]);
        if (isset($ip_and_mask[1])) {
            $this->setCustomAddressMask($ip_and_mask[1]);
        }
        return $this->getNetwork();
    }

    public function setCustomNumericAddress(string $address): Network
    {
        return $this->getNetwork()->setNumericIpV4(ip2long($address));
    }

    public function setCustomAddressMask(string $address): Network
    {
        $this->getNetwork()->setIpV4Mask($address);
        $this->setCustomNumericAddressMask($address);
        return $this->getNetwork();
    }

    public function setCustomNumericAddressMask(string $address): Network
    {
        return $this->getNetwork()->setNumericIpV4Mask(0xffffffff << (32 - $address));
    }

    public function getCustomAddress(): string
    {
        return $this->getNetwork()->getIpV4();
    }

    public function getCustomAddressMask(): string
    {
        return $this->getNetwork()->getIpV4Mask();
    }

    public function getCustomNumericAddress(): string
    {
        return $this->getNetwork()->getNumericIpV4();
    }

    public function getCustomNumericAddressMask(): string
    {
        return $this->getNetwork()->getNumericIpV4Mask();
    }

    public function equal(): bool
    {
        // TODO: Implement equal() method.
    }

    public function getType(): string
    {
        return 'ip_v4';
    }
}
