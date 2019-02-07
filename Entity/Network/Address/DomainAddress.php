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


    public function setCustomAddress(string $address): NetworkElement
    {
        $this->getNetwork()->setDomain($address);
        $this->setCustomNumericAddress($address);
        return $this->getNetwork();
    }

    public function setCustomNumericAddress(string $address): NetworkElement
    {
        return $this->getNetwork()->setNumericDomain(substr_count($address, '.') + 1);
    }

    public function setCustomAddressMask(string $address): NetworkElement
    {
        $this->getNetwork()->setDomain($address);
        $this->setCustomNumericAddressMask($address);
        return $this->getNetwork();
    }

    public function setCustomNumericAddressMask(string $address): NetworkElement
    {
        return $this->getNetwork();
    }

    public function getCustomAddress(): string
    {
        return $this->getNetwork()->getDomain();
    }

    public function getCustomAddressMask(): string
    {
        return '';
    }

    public function getCustomNumericAddress(): string
    {
        return $this->getNetwork()->getNumericDomain();
    }

    public function getCustomNumericAddressMask(): string
    {
        return '';
    }

    public function getType(): string
    {
        return 'domain';
    }
}
