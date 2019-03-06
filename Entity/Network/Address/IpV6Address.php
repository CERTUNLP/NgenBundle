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
class IpV6Address extends IpAddress
{


    public function getDefaultIpMask(): int
    {
        return 128;
    }


    public function getCustomNumericAddress(): string
    {
        return inet_pton($this->getCustomAddress());
    }


    public function getCustomNumericAddressMask(): string
    {
        return $this->maskTobits($this->getCustomAddress());
    }

    private function maskTobits(string $mask)
    {
        $addr = str_repeat('f', $mask / 4);
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

    public function getType(): string
    {
        return 'ip_v6';
    }
}
