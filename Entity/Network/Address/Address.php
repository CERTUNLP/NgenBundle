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
abstract class Address
{

    protected $network;

    public function __construct(Network $network)
    {
        $this->network = $network;
    }

    public function __toString(): string
    {
        return $this->getCustomAddress() . ($this->getCustomAddressMask() ? '/' . $this->getCustomAddressMask() : '');

    }

    abstract public function getCustomAddress(): string;

    abstract public function getCustomAddressMask(): string;

    abstract public function getType(): string;

    public function getNetwork(): Network
    {
        return $this->network;
    }

    public function setNetwork(Network $network): Address
    {
        $this->network = $network;
        return $this;
    }

    public function setAddress(string $address): Network
    {
        return $this->setCustomAddress($address);
    }

    abstract public function setCustomAddress(string $address): Network;

    abstract public function setCustomNumericAddress(string $address): Network;

    abstract public function getCustomNumericAddress(): string;

    abstract public function setCustomNumericAddressMask(string $address): Network;

    abstract public function getCustomNumericAddressMask(): string;

    public function equals(Address $other = null): bool
    {
        if ($other) {
            return ($this->getAddress() === $other->getAddress()) && ($this->getAddressMask() === $other->getAddressMask());
        }
        return false;

    }

    public function getAddress(): string
    {
        return $this->getCustomAddress();
    }

    public function getAddressMask(): string
    {
        return $this->getCustomAddressMask();
    }

    public function setAddressMask(string $address): Network
    {
        return $this->setCustomAddressMask($address);
    }

    abstract public function setCustomAddressMask(string $address): Network;


}
