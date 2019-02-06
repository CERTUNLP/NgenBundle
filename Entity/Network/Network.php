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

use CertUnlp\NgenBundle\Entity\Incident\Host\Host;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use CertUnlp\NgenBundle\Entity\Network\Address\Address;
use CertUnlp\NgenBundle\Entity\Network\Address\DomainAddress;
use CertUnlp\NgenBundle\Entity\Network\Address\IpV4Address;
use CertUnlp\NgenBundle\Entity\Network\Address\IpV6Address;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Network
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\NetworkRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"internal" = "NetworkInternal", "external" = "NetworkExternal", "rdap" = "NetworkRdap"})
 * @JMS\ExclusionPolicy("all")
 * @ORM\EntityListeners({ "CertUnlp\NgenBundle\Entity\Network\Listener\NetworkListener" })
 */
abstract class Network implements NetworkInterface
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_v4_mask", type="string", length=40, nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 32,
     * )
     * @JMS\Expose
     */
    protected $ip_v4_mask;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_v6_mask", type="string", length=3, nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 128,
     * )
     * @JMS\Expose
     */
    protected $ip_v6_mask;

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
     * @var int
     *
     * @ORM\Column(name="numeric_domain", type="integer",options={"unsigned":true}, nullable=true)
     */
    protected $numericDomain;
    /**
     * @var int
     *
     * @ORM\Column(name="numeric_ip_v4_mask",type="bigint", options={"unsigned":true}, nullable=true)
     */
    protected $numericIpV4Mask;
    /**
     * @var int
     *
     * @ORM\Column(type="integer",options={"unsigned":true}, nullable=true)
     */
    protected $numericIpV4;
    /**
     * @var int
     * @ORM\Column(name="numeric_ip_v6_mask",type="binary", length=16, nullable=true)
     */
    protected $numericIpV6Mask;
    /**
     * @var int
     *
     * @ORM\Column( type="binary",length=16, nullable=true)
     */
    protected $numericIpV6;
    /**
     * @var NetworkAdmin
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\NetworkAdmin", inversedBy="networks",cascade={"persist"})
     * @JMS\Expose
     */
    protected $network_admin;
    /**
     * @var NetworkEntity
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\NetworkEntity", inversedBy="networks",cascade={"persist"})
     * @JMS\Expose
     */
    protected $network_entity;
    /**
     * @var Collection| Incident[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="network"))
     */
    protected $incidents;
    /**
     * @var Collection| Host[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Host\Host",mappedBy="network", cascade={"persist"}))
     */
    protected $hosts;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    protected $isActive = true;
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    protected $createdAt;
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    protected $updatedAt;
    /**
     * @var Address
     */
    protected $address;

    /**
     * Constructor
     * @param string $term
     */
    public function __construct(string $term = '')
    {
        if ($term) {
            $this->guessAddress($term);
        }
        $this->incidents = new ArrayCollection();
    }

    public function guessAddress(string $term): Network
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
     * @return Network
     */
    public function setAddress(string $address): Network
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
            return $this->address->equals($other->address);
        }
        return false;

    }

    /**
     * @return string
     */
    public function getIpV4Mask(): string
    {
        return $this->ip_v4_mask;
    }

    /**
     * Set ipMask
     *
     * @param string $ip_v4_mask
     * @return Network
     */
    public function setIpV4Mask(string $ip_v4_mask): Network
    {
        $this->ip_v4_mask = $ip_v4_mask;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpV6Mask(): string
    {
        return $this->ip_v6_mask;
    }

    /**
     * Set ipMask
     *
     * @param string $ip_v6_mask
     * @return Network
     */
    public function setIpV6Mask(string $ip_v6_mask): Network
    {
        $this->ip_v6_mask = $ip_v6_mask;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumericIpV6Mask(): int
    {
        return $this->numericIpV6Mask;
    }

    /**
     * @param string $numericIpV6Mask
     * @return Network
     */
    public function setNumericIpV6Mask(string $numericIpV6Mask): Network
    {
        $this->numericIpV6Mask = $numericIpV6Mask;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumericIpV6(): string
    {
        return $this->numericIpV6;
    }

    /**
     * @param string $numericIpV6
     * @return Network
     */
    public function setNumericIpV6(string $numericIpV6): Network
    {
        $this->numericIpV6 = $numericIpV6;
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
     * @return Network
     */
    public function setIpV6(string $ip_v6): Network
    {
        $this->ip_v6 = $ip_v6;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumericDomain(): int
    {
        return $this->numericDomain;
    }

    /**
     * @param int $numericDomain
     * @return Network
     */
    public function setNumericDomain(int $numericDomain): Network
    {
        $this->numericDomain = $numericDomain;
        return $this;
    }

    /**
     * @return NetworkAdmin
     */
    public function getNetworkAdmin(): ?NetworkAdmin
    {
        return $this->network_admin;
    }

    /**
     * @param NetworkAdmin $network_admin
     * @return Network
     */
    public function setNetworkAdmin(NetworkAdmin $network_admin = null): Network
    {
        $this->network_admin = $network_admin;
        return $this;
    }

    /**
     * @return NetworkEntity
     */
    public function getNetworkEntity(): ?NetworkEntity
    {
        return $this->network_entity;
    }

    /**
     * @param NetworkEntity $network_entity
     * @return Network
     */
    public function setNetworkEntity(NetworkEntity $network_entity = null): Network
    {
        $this->network_entity = $network_entity;
        return $this;
    }

    /**
     * @return Host[]|Collection
     */
    public function getHosts(): Collection
    {
        return $this->hosts;
    }

    /**
     * @param Host $hosts
     * @return Network
     */
    public function setHosts(Host $hosts): Network
    {
        $this->hosts = $hosts;
        return $this;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     * @return Network
     */
    public function setDomain(string $domain): Network
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
     * @return Network
     */
    public function setIpV4(string $ip): Network
    {
        $this->ip_v4 = $ip;
        return $this;
    }

    /**
     * Add incidents
     *
     * @param \CertUnlp\NgenBundle\Entity\Incident\Incident $incidents
     * @return Network
     */
    public function addIncident(Incident $incidents): Network
    {
        $this->incidents[] = $incidents;

        return $this;
    }

    /**
     * Remove incidents
     *
     * @param Incident $incidents
     * @return bool
     */
    public function removeIncident(Incident $incidents): bool
    {
        return $this->incidents->removeElement($incidents);
    }

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    /**
     * @param Incident[]|Collection $incidents
     * @return Network
     */
    public function setIncidents(Collection $incidents): Network
    {
        $this->incidents = $incidents;
        return $this;
    }

    /**
     * Get numericIp
     *
     * @return int
     */
    public function getNumericIpV4(): int
    {
        return $this->numericIpV4;
    }

    /**
     * Set numericIp
     *
     * @param integer $numericIpV4
     * @return Network
     */
    public function setNumericIpV4(int $numericIpV4): Network
    {
        $this->numericIpV4 = $numericIpV4;

        return $this;
    }

    /**
     * Get numericIpMask
     *
     * @return int
     */
    public function getNumericIpV4Mask(): int
    {
        return $this->numericIpV4Mask;
    }

    /**
     * Set numericIpMask
     *
     * @param int $numericIpV4Mask
     * @return Network
     */
    public function setNumericIpV4Mask(int $numericIpV4Mask): Network
    {
        $this->numericIpV4Mask = $numericIpV4Mask;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Network
     */
    public function setId(int $id): Network
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return Network
     */
    public function setIsActive(bool $isActive): Network
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Network
     */
    public function setCreatedAt(\DateTime $createdAt): Network
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Network
     */
    public function setUpdatedAt(\DateTime $updatedAt): Network
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return IncidentDecision[]|Collection
     */
    public function getIncidentsDecisions(): Collection
    {
        return $this->incidentsDecisions;
    }

    /**
     * @param IncidentDecision[]|Collection $incidentsDecisions
     * @return Network
     */
    public function setIncidentsDecisions(Collection $incidentsDecisions): Network
    {
        $this->incidentsDecisions = $incidentsDecisions;
        return $this;
    }


}
