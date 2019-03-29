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
class DomainAddress extends Address
{

    public function inRange(Address $other = null): bool
    {
        return false;

    }

    public function getCustomAddressMask(): string
    {
        return substr_count($this->getCustomAddress(), '.') + 1;
    }

    public function getCustomAddress(): string
    {
        return $this->getNetwork()->getDomain();
    }

    public function setCustomAddress(string $address): NetworkElement
    {
        $this->getNetwork()->setDomain($address);
        return $this->getNetwork();
    }

    public function setCustomAddressMask(string $address): NetworkElement
    {
        $this->getNetwork()->setDomain($address);
        return $this->getNetwork();
    }

    public function getType(): string
    {
        return 'domain';
    }

    public function getCustomNumericAddress(): string
    {
        return '';
    }

    public function getCustomNumericAddressMask(): string
    {
        return '';
    }

}
