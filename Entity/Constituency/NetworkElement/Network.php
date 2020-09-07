<?php
/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Constituency\NetworkElement;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkEntity;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Constituency\NetworkElement\NetworkRepository")
 * @ORM\EntityListeners({"CertUnlp\NgenBundle\Service\Listener\Entity\NetworkListener"})
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"domain"},
 *     errorPath="address",
 *     message="A network with the same address: {{ value }} already exist."
 * )
 * @UniqueEntity(
 *     fields={"ip_start_address","ip_end_address"},
 *     errorPath="address",
 *     message="A network with the same address: {{ value }} already exist."
 * )
 */
class Network extends NetworkElement implements NetworkInterface
{
    /**
     * @var string
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 128,
     * )
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $ip_mask;
    /**
     * @var NetworkAdmin
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Constituency\NetworkAdmin", inversedBy="networks",cascade={"persist"})
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $network_admin;
    /**
     * @var NetworkEntity
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Constituency\NetworkEntity", inversedBy="networks",cascade={"persist"})
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $network_entity;
    /**
     * @var Collection| Incident[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="network",fetch="EXTRA_LAZY")
     */
    private $incidents;
    /**
     * @var Collection| Host[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Host",mappedBy="network", cascade={"persist"},fetch="EXTRA_LAZY")
     */
    private $hosts;
    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $ip_start_address;
    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $ip_end_address;
    /**
     * @var string
     * @ORM\Column(type="string",length=2,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $country_code;
    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $asn;
    /**
     * @var string
     * @ORM\Column(type="string", columnDefinition="ENUM('internal', 'external','rdap')")s
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $type = 'internal';

    public function __construct(string $term = null)
    {
        parent::__construct($term);
        $this->incidents = new ArrayCollection();
        $this->hosts = new ArrayCollection();
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
     * @param NetworkAdmin|null $network_admin
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
     * @param NetworkEntity|null $network_entity
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

    public function addHost(Host $host): ?Network
    {
        if ($this->hosts->contains($host)) {
            return $this;
        }
        $this->hosts[] = $host;
        $host->setNetwork($this);
        return $this;

    }

    public function removeHost(Host $host): ?Network
    {
        if (!$this->hosts->contains($host)) {
            return $this;
        }
        $this->hosts->removeElement($host);
        $host->setNetwork(null);
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
        return $this->getLiveIncidents()->filter(static function (Incident $incident) use ($type) {
            return $incident->getType()->getSlug() === $type;
        });
    }

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getLiveIncidents(): Collection
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
     * @return bool
     */
    public function canEditFundamentals(): bool
    {
        return $this->getDeadIncidents()->isEmpty() && $this->getAddressMask() !== "0";
    }

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getDeadIncidents(): Collection
    {
        return $this->getIncidents()->filter(static function (Incident $incident) {
            return $incident->isDead();
        });
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
    public function setCountryCode(?string $country_code): Network
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

    /**
     * {@inheritDoc}
     */
    public function getDataIdentificationArray(): array
    {
        return ['address' => $this->getAddressAndMask()];
    }

    public function __toString(): string
    {
        return $this->getAddressAndMask() . ' (' . strtolower($this->getType()) . ')';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Network
     */
    public function setType(string $type): Network
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        switch ($this->getType()) {
            case'rdap':
                return 'project-diagram';
            case'external':
                return 'share-alt';
            default:
                return 'share-alt-square';
        }
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        switch ($this->getType()) {
            case'rdap':
            case'external':
                return 'primary';
            default:
                return 'info';
        }
    }

    /**
     * @return bool
     */
    public function isInternal(): bool
    {
        switch ($this->getType()) {
            case'rdap':
            case'external':
                return false;
            default:
                return true;
        }
    }
}
