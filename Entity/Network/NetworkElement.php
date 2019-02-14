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
     * @ORM\Column(type="string", length=15, nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @Assert\Ip(version="4")
     */
    protected $ip_v4;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=39, nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @Assert\Ip(version="6")
     */
    protected $ip_v6;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     *
     */
    protected $domain;

    /**
     * @var Address
     */
    protected $address;

    public function getAddressAndMask(): string
    {
        return $this->getAddress() . ($this->getAddressMask() ? '/' . $this->getAddressMask() : '');
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address->getAddress();
    }

    /**
     * @param string $address
     * @return NetworkElement
     */
    public function setAddress(string $address): NetworkElement
    {
        if (!$this->address) {
            $this->guessAddress($address);
        }

        return $this->address->setAddress($address);
    }

    /**
     * @return string
     */
    public function getAddressMask(): string
    {
        return $this->address->getAddressMask();
    }

    public function guessAddress(string $term): NetworkElement
    {
        $whitout_mask = explode('/', $term)[0];

        switch ($this::guessType($whitout_mask)) {
            case FILTER_FLAG_IPV4:
                $address = new IpV4Address($this);
                break;
            case FILTER_FLAG_IPV6:
                $address = new IpV6Address($this);
                break;
            case FILTER_VALIDATE_DOMAIN:
                $address = new DomainAddress($this);
                break;
            default:
                $address = null;
        }
        $address->setAddress($term);
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

        if (filter_var(gethostbyname($term), FILTER_VALIDATE_DOMAIN)) {
            return FILTER_VALIDATE_DOMAIN;

        }
        return 0;
    }

    /**
     * @return Address
     */
    public function getAddressObject(): Address
    {
        return $this->address;
    }

    public function equals(Network $other = null): bool
    {
        if ($other) {
            return $this->address->equals($other->getAddressObject());
        }
        return false;

    }

    /**
     * @return string
     */
    public function getIpV4Mask(): ?string
    {
        return $this->ip_v4_mask;
    }

    /**
     * Set ipMask
     *
     * @param string $ip_v4_mask
     * @return NetworkElement
     */
    public function setIpV4Mask(string $ip_v4_mask): NetworkElement
    {
        $this->ip_v4_mask = $ip_v4_mask;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpV6Mask(): ?string
    {
        return $this->ip_v6_mask;
    }

    /**
     * Set ipMask
     *
     * @param string $ip_v6_mask
     * @return NetworkElement
     */
    public function setIpV6Mask(string $ip_v6_mask): NetworkElement
    {
        $this->ip_v6_mask = $ip_v6_mask;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumericIpV6Mask(): int
    {
        return $this->numeric_ip_v6_mask;
    }

    /**
     * @param string $numeric_ip_v6_mask
     * @return NetworkElement
     */
    public function setNumericIpV6Mask(string $numeric_ip_v6_mask): NetworkElement
    {
        $this->numeric_ip_v6_mask = $numeric_ip_v6_mask;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumericIpV6(): string
    {
        return $this->numeric_ip_v6;
    }

    /**
     * @param string $numeric_ip_v6
     * @return NetworkElement
     */
    public function setNumericIpV6(string $numeric_ip_v6): NetworkElement
    {
        $this->numeric_ip_v6 = $numeric_ip_v6;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpV6(): ?string
    {
        return $this->ip_v6;
    }

    /**
     * @param string $ip_v6
     * @return NetworkElement
     */
    public function setIpV6(string $ip_v6): NetworkElement
    {
        $this->ip_v6 = $ip_v6;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumericDomain(): ?int
    {
        return $this->numeric_domain;
    }

    /**
     * @param int $numeric_domain
     * @return NetworkElement
     */
    public function setNumericDomain(int $numeric_domain): NetworkElement
    {
        $this->numeric_domain = $numeric_domain;
        return $this;
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


    /**
     * @return string
     */
    public function getIpV4(): ?string
    {
        return $this->ip_v4;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return NetworkElement
     */
    public function setIpV4(string $ip): NetworkElement
    {
        $this->ip_v4 = $ip;
        return $this;
    }

    /**
     * Get numericIp
     *
     * @return int
     */
    public function getNumericIpV4(): int
    {
        return $this->numeric_ip_v4;
    }

    /**
     * Set numericIp
     *
     * @param int $numeric_ip_v4
     * @return NetworkElement
     */
    public function setNumericIpV4(int $numeric_ip_v4): NetworkElement
    {
        $this->numeric_ip_v4 = $numeric_ip_v4;

        return $this;
    }

    /**
     * Get numericIpMask
     *
     * @return int
     */
    public function getNumericIpV4Mask(): int
    {
        return $this->numeric_ip_v4_mask;
    }

    /**
     * Set numericIpMask
     *
     * @param int $numeric_ip_v4_mask
     * @return NetworkElement
     */
    public function setNumericIpV4Mask(int $numeric_ip_v4_mask): NetworkElement
    {
        $this->numeric_ip_v4_mask = $numeric_ip_v4_mask;

        return $this;
    }


}
