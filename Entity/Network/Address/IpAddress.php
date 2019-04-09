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
use Darsyn\IP\Exception\InvalidCidrException;
use Darsyn\IP\Exception\InvalidIpAddressException;
use Darsyn\IP\Exception\WrongVersionException;
use Darsyn\IP\Version\Multi as IP;
use JMS\Serializer\Annotation as JMS;

/**
 *
 * @JMS\ExclusionPolicy("all")
 */
abstract class IpAddress extends Address
{
    /**
     * @var IP;
     */
    protected $ip;

    /**
     * @return string
     */
    public function getCustomEndAddress(): string
    {
        $this->getNetwork()->getEndAddress();
    }

    /**
     * @return string
     */
    public function getCustomStartAddress(): string
    {
        $this->getNetwork()->getStartAddress();
    }

    /**
     * @param string $address
     * @return NetworkElement
     * @throws InvalidCidrException
     * @throws InvalidIpAddressException
     * @throws WrongVersionException
     */
    public function setCustomAddress(string $address): NetworkElement
    {
        $ip_and_mask = explode('/', $address);
        $this->setIp(IP::factory($ip_and_mask[0]));
        $this->getNetwork()->setIp($this->getCustomAddress());
        if (isset($ip_and_mask[1])) {
            $this->setCustomAddressMask($ip_and_mask[1]);
        } else {
            $this->setCustomAddressMask($this->getDefaultIpMask());

        }
        $this->setCustomStartAddress();
        $this->setCustomEndAddress();
        return $this->getNetwork();
    }

    public function getCustomAddress(): string
    {
        return $this->getIp()->getProtocolAppropriateAddress();
    }

    /**
     * @return IP
     */
    public function getIp(): IP
    {
        return $this->ip;
    }

    /**
     * @param IP $ip
     * @return IpAddress
     */
    public function setIp(IP $ip): IpAddress
    {
        $this->ip = $ip;
        return $this;
    }

    public function setCustomAddressMask(string $mask): NetworkElement
    {
        if (is_callable([$this->getNetwork(), 'setIpMask'])) {
            return $this->getNetwork()->setIpMask($mask);
        }
        return $this->getNetwork();
    }

    /**
     * @return int
     */
    abstract public function getDefaultIpMask(): int;

    /**
     * @return IpAddress
     * @throws InvalidCidrException
     */
    public function setCustomStartAddress(): IpAddress
    {
        if (is_callable([$this->getNetwork(), 'setStartAddress'])) {
            $this->getNetwork()->setStartAddress($this->getIp()->getNetworkIp((int)$this->getCustomAddressMask())->getProtocolAppropriateAddress());
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomAddressMask(): string
    {
        if (is_callable([$this->getNetwork(), 'getIpMask'])) {
            return $this->getNetwork()->getIpMask();
        }
        return '';
    }

    /**
     * @return IpAddress
     * @throws InvalidCidrException
     */
    public function setCustomEndAddress(): IpAddress
    {
        if (is_callable([$this->getNetwork(), 'setEndAddress'])) {
            $this->getNetwork()->setEndAddress($this->getIp()->getBroadcastIp((int)$this->getCustomAddressMask())->getProtocolAppropriateAddress());
        }
        return $this;
    }

    public function inRange(Address $other = null): bool
    {
        if ($other && get_class($other) === get_class($this)) {
            return $this->getIp()->inRange($other->getIp(), (int)$other->getCustomAddressMask());
        }
        return false;

    }
}
