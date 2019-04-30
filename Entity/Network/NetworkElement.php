<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Network;

use CertUnlp\NgenBundle\Entity\Network\Address\Address;
use CertUnlp\NgenBundle\Entity\Network\Address\DomainAddress;
use CertUnlp\NgenBundle\Entity\Network\Address\IpV4Address;
use CertUnlp\NgenBundle\Entity\Network\Address\IpV6Address;
use CertUnlp\NgenBundle\Validator\Constraints as CustomAssert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NetworkElement
 *
 * @JMS\ExclusionPolicy("all")
 */
abstract class NetworkElement
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=39, nullable=true)
     * @JMS\Expose
     * @JMS\SerializedName("address")
     * @JMS\Groups({"api"})
     * @CustomAssert\ValidAddress()
     */
    protected $ip;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\Expose
     * @JMS\SerializedName("address")
     * @JMS\Groups({"api"})
     * @CustomAssert\ValidAddress()
     */
    protected $domain;

    /**
     * @var Address
     * @Assert\NotNull(message="not a valid address")
     */
    protected $address;

    /**
     * Host constructor.
     * @param string|null $term
     */
    public function __construct(string $term = null)
    {
        if ($term) {
            $this->guessAddress($term);
        }
    }

    public function guessAddress(string $term): NetworkElement
    {
        $whitout_mask = explode('/', $term)[0];

        switch ($this::guessType($whitout_mask)) {
            case FILTER_FLAG_IPV4:
                $address = new IpV4Address($this, $term);
                break;
            case FILTER_FLAG_IPV6:
                $address = new IpV6Address($this, $term);
                break;
            case FILTER_VALIDATE_DOMAIN:
                $address = new DomainAddress($this, $term);
                break;
            default:
                $address = null;
        }
        $this->address = $address;

        return $this;
    }

    public static function guessType(string $term): int
    {
        if (filter_var($term, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return FILTER_FLAG_IPV4;
        }

        if (filter_var($term, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return FILTER_FLAG_IPV6;
        }
        if (filter_var($term, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            return FILTER_VALIDATE_DOMAIN;

        }
        return 0;
    }

    public function getAddressAndMask(): string
    {
        return $this->getAddress() . ($this->getAddressMask() ? '/' . $this->getAddressMask() : '');
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address ? $this->address->getAddress() : '';
    }

    /**
     * @param string $address
     * @return NetworkElement
     */
    public function setAddress(string $address): NetworkElement
    {
        return $this->guessAddress($address);
    }

    /**
     * @return string
     */
    public function getAddressMask(): string
    {
        return $this->address ? $this->address->getAddressMask() : '';
    }


    /**
     * @return string
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return NetworkElement
     */
    public function setIp(string $ip): NetworkElement
    {
        $this->ip = $ip;
        return $this;
    }

    public function equals(NetworkElement $other = null): bool
    {
        if ($other) {
            return $this->address->equals($other->getAddressObject());
        }
        return false;

    }

    /**
     * @return Address
     */
    public function getAddressObject(): Address
    {
        return $this->address;
    }

    public function inRange(NetworkElement $other = null): bool
    {
        if ($other) {
            return $this->address->inRange($other->getAddressObject());
        }
        return false;

    }

    /**
     * @return string
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     * @return NetworkElement
     */
    public function setDomain(string $domain): NetworkElement
    {
        $this->domain = $domain;
        return $this;
    }

    public function __toString(): string
    {
        return $this->address->__toString();
    }


}
