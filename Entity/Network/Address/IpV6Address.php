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

use CertUnlp\NgenBundle\Entity\Network\NetworkElement;
use JMS\Serializer\Annotation as JMS;

/**
 *
 * @JMS\ExclusionPolicy("all")
 */
class IpV6Address extends Address
{

    public function setCustomAddress(string $address): NetworkElement
    {
        $ip_and_mask = explode('/', $address);
        $this->getNetwork()->setIpV6($ip_and_mask[0]);
        $this->setCustomNumericAddress($ip_and_mask[0]);
        if (isset($ip_and_mask[1])) {
            $this->setCustomAddressMask($ip_and_mask[1]);
        }
        return $this->getNetwork();
    }

    public function setCustomNumericAddress(string $address): NetworkElement
    {
        return $this->getNetwork()->setNumericIpV6(inet_pton($address));
    }

    public function setCustomAddressMask(string $address): NetworkElement
    {
        $this->getNetwork()->setIpV6Mask($address);
        $this->setCustomNumericAddressMask($address);
        return $this->getNetwork();
    }

    public function setCustomNumericAddressMask(string $address): NetworkElement
    {

        return $this->getNetwork()->setNumericIpV6Mask($this->maskTobits($address));
    }

    private function maskTobits(string $mask)
    {
        $addr = str_repeat("f", $mask / 4);
        switch ($mask % 4) {
            case 0:
                break;
            case 1:
                $addr .= '8';
                break;
            case 2:
                $addr .= 'c';
                break;
            case 3:
                $addr .= 'e';
                break;
        }
        $addr = str_pad($addr, 32, '0');
        $addr = pack('H*', $addr);
        return $addr;
    }

    public function getCustomAddress(): string
    {
        return $this->getNetwork()->getIpV6();
    }

    public function getCustomAddressMask(): string
    {
        return $this->getNetwork()->getIpV6Mask();
    }

    public function getCustomNumericAddress(): string
    {
        return $this->getNetwork()->getNumericIpV6();
    }

    public function getCustomNumericAddressMask(): string
    {
        return $this->getNetwork()->getNumericIpV6Mask();
    }

    public function equal(): bool
    {
        // TODO: Implement equal() method.
    }

    public function getType(): string
    {
        return 'ip_v6';
    }
}
