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
abstract class Address
{

    /**
     * @var NetworkElement
     */
    private $network;

    public function __construct(NetworkElement $network, string $term)
    {
        $this->network = $network;
        $this->setAddress($term);
    }

    /**
     * @param string $address
     * @return NetworkElement
     */
    public function setAddress(string $address): NetworkElement
    {
        return $this->setCustomAddress($address);
    }

    /**
     * @param string $address
     * @return NetworkElement
     */
    abstract public function setCustomAddress(string $address): NetworkElement;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getCustomAddress();

    }

    /**
     * @return string
     */
    abstract public function getCustomAddress(): string;

    /**
     * @return string
     */
    abstract public function getType(): string;

    /**
     * @return NetworkElement
     */
    public function getNetwork(): NetworkElement
    {
        return $this->network;
    }

    /**
     * @param NetworkElement $network
     * @return $this
     */
    public function setNetwork(NetworkElement $network): Address
    {
        $this->network = $network;
        return $this;
    }

    /**
     * @param Address|null $other
     * @return bool
     */
    abstract public function inRange(Address $other = null): bool;

    /**
     * @return string
     */
    abstract public function getCustomNumericAddress(): string;

    /**
     * @return string
     */
    abstract public function getCustomNumericAddressMask(): string;

    /**
     * @param Address|null $other
     * @return bool
     */
    public function equals(Address $other = null): bool
    {
        if ($other) {
            return ($this->getAddress() === $other->getAddress()) && ($this->getAddressMask() === $other->getAddressMask());
        }
        return false;

    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->getCustomAddress();
    }

    /**
     * @return string
     */
    public function getAddressMask(): string
    {
        return $this->getCustomAddressMask();
    }

    /**
     * @return string
     */
    abstract public function getCustomAddressMask(): string;

    /**
     * @param string $address
     * @return NetworkElement
     */
    public function setAddressMask(string $address): NetworkElement
    {
        return $this->setCustomAddressMask($address);
    }

    /**
     * @param string $address
     * @return NetworkElement
     */
    abstract public function setCustomAddressMask(string $address): NetworkElement;


}
