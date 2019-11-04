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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Network\Host\Host;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use DateTime;
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
abstract class Network extends NetworkElement implements NetworkInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40, nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 128,
     * )
     * @JMS\Expose
     */
    protected $ip_mask;
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
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="network",fetch="EXTRA_LAZY")
     */
    protected $incidents;
    /**
     * @var Collection| Host[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Network\Host\Host",mappedBy="network", cascade={"persist"},fetch="EXTRA_LAZY")
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
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    protected $createdAt;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    protected $updatedAt;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $ip_start_address;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $ip_end_address;
    /**
     * @ORM\Column(type="string",length=2,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $country_code;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $asn;

    public function __construct(string $term = null)
    {
        parent::__construct($term);
        $this->incidents = new ArrayCollection();
    }


    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'info';
    }

    public function getType(): string
    {
        $array = explode('\\', static::class);
        return strtolower(str_replace('Network', '', array_pop($array)));
    }

    /**
     * Get startAddress
     *
     * @return string
     */
    public function getStartAddress(): ?string
    {
        return $this->ip_start_address;
    }

    /**
     * Set startAddress
     *
     * @param string $startAddress
     *
     * @return Network
     */
    public function setStartAddress(string $startAddress): Network
    {
        $this->ip_start_address = $startAddress;

        return $this;
    }

    /**
     * Get endAddress
     *
     * @return string
     */
    public function getEndAddress(): ?string
    {
        return $this->ip_end_address;
    }

    /**
     * @param string $end_address
     * @return Network
     */
    public function setEndAddress(string $end_address): Network
    {
        $this->ip_end_address = $end_address;
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
     * @return string
     */
    public function getIpMask(): ?string
    {
        return $this->ip_mask;
    }

    /**
     * Set ipMask
     *
     * @param string $ip_mask
     * @return NetworkElement
     */
    public function setIpMask(string $ip_mask): NetworkElement
    {
        $this->ip_mask = $ip_mask;
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
     * Add incidents
     *
     * @param Incident $incidents
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
     * @param string $type
     * @return Collection
     */
    public function getliveIncidentsOfType(string $type): Collection
    {
        return $this->getliveIncidents()->filter(static function (Incident $incident) use ($type) {
            return $incident->getType()->getSlug() === $type;
        });
    }

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getliveIncidents(): Collection
    {
        return $this->getIncidents()->filter(static function (Incident $incident) {
            return $incident->isLive();
        });
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
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Network
     */
    public function setCreatedAt(DateTime $createdAt): Network
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return Network
     */
    public function setUpdatedAt(DateTime $updatedAt): Network
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    /**
     * @param mixed $country_code
     * @return Network
     */
    public function setCountryCode(string $country_code): Network
    {
        $this->country_code = $country_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getAsn(): string
    {
        return $this->asn;
    }

    /**
     * @param string $asn
     * @return Network
     */
    public function setAsn(string $asn): string
    {
        $this->asn = $asn;
        return $this;
    }


}
