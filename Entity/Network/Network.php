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
use CertUnlp\NgenBundle\Model\NetworkInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Network
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\NetworkRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"internal" = "NetworkInternal", "external" = "NetworkExternal", "rdap" = "NetworkRdap"})
 * @UniqueEntity(
 *     fields={"ip_v4", "ipMask","isActive"},
 *     message="This network was already added!")
 * @JMS\ExclusionPolicy("all")
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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_mask", type="string", length=40)
     * @Assert\Range(
     *      min = 1,
     *      max = 32,
     * )
     * @JMS\Expose
     */
    private $ipMask;

    /**
     * @var int
     *
     * @ORM\Column(name="numeric_ip_mask", type="bigint", options={"unsigned":true})
     */
    private $numericIpMask;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=15, nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @Assert\Ip(version="4_no_priv")
     */
    private $ip_v4;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=39, nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @Assert\Ip(version="6_no_priv")
     */
    private $ip_v6;
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     *
     * @Assert\Url()
     */
    private $url;
    /**
     * @var int
     *
     * @ORM\Column(name="numeric_ip", type="integer",options={"unsigned":true})
     */
    private $numericIp;
    /**
     * @var NetworkAdmin
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\NetworkAdmin", inversedBy="networks",cascade={"persist"})
     * @JMS\Expose
     */
    private $network_admin;
    /**
     * @var NetworkEntity
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\NetworkEntity", inversedBy="networks",cascade={"persist"})
     * @JMS\Expose
     */
    private $network_entity;
    /**
     * @var Collection| Incident[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="network"))
     */
    private $incidents;
    /**
     * @var Collection| Host[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Host\Host",mappedBy="network", cascade={"persist"}))
     */
    private $hosts;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;

    /**
     * Constructor
     * @param string $ip_v4
     */
    public function __construct(string $ip_v4 = '')
    {
        if ($ip_v4) {
            $this->ip_v4 = $ip_v4;
        }
        $this->incidents = new ArrayCollection();
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
    public function getIpV6(): string
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
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Network
     */
    public function setUrl(string $url): Network
    {
        $this->url = $url;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getIpAndMask();
    }

    public function getIpAndMask(): string
    {


        return $this->getIp() . '/' . $this->getIpMask();
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp(): ?string
    {
        return $this->getIpV4();
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

        $ip_and_mask = explode('/', $ip);
        $this->ip_v4 = $ip_and_mask[0];
        $this->setNumericIp(ip2long($ip_and_mask[0]));
        if (isset($ip_and_mask[1])) {
            $this->setIpMask($ip_and_mask[1]);
        }
        return $this;
    }

    /**
     * Get ipMask
     *
     * @return string
     */
    public function getIpMask(): ?string
    {
        return $this->ipMask;
    }

    /**
     * Set ipMask
     *
     * @param string $ipMask
     * @return Network
     */
    public function setIpMask(string $ipMask): Network
    {
        $this->ipMask = $ipMask;
        $this->setNumericIpMask(0xffffffff << (32 - $ipMask));

        return $this;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Network
     */
    public function setIp(string $ip): Network
    {

        $this->setIpV4($ip);
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
     * {@inheritDoc}
     */
    public function equals(Network $other = null): bool
    {
        if ($other) {
            return ($this->getNumericIp() === $other->getNumericIp()) && ($this->getNumericIpMask() === $other->getNumericIpMask());
        }
        return false;

    }

    /**
     * Get numericIp
     *
     * @return int
     */
    public function getNumericIp(): int
    {
        return $this->numericIp;
    }

    /**
     * Set numericIp
     *
     * @param integer $numericIp
     * @return Network
     */
    public function setNumericIp(int $numericIp): Network
    {
        $this->numericIp = $numericIp;

        return $this;
    }

    /**
     * Get numericIpMask
     *
     * @return int
     */
    public function getNumericIpMask(): int
    {
        return $this->numericIpMask;
    }

    /**
     * Set numericIpMask
     *
     * @param int $numericIpMask
     * @return Network
     */
    public function setNumericIpMask(int $numericIpMask): Network
    {
        $this->numericIpMask = $numericIpMask;

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
