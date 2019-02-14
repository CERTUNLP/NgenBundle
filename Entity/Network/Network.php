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
use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use CertUnlp\NgenBundle\Entity\Network\Host\Host;
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
abstract class Network extends NetworkElement implements NetworkInterface
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
     * @var int
     *
     * @ORM\Column(name="numeric_ip_v4_mask",type="bigint", options={"unsigned":true}, nullable=true)
     */
    protected $numeric_ip_v4_mask;

    /**
     * @var int
     *
     * @ORM\Column(type="integer",options={"unsigned":true}, nullable=true)
     */
    protected $numeric_ip_v4;

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
     * @var int
     * @ORM\Column(name="numeric_ip_v6_mask",type="binary", length=16, nullable=true)
     */
    protected $numeric_ip_v6_mask;

    /**
     * @var int
     *
     * @ORM\Column( type="binary",length=16, nullable=true)
     */
    protected $numeric_ip_v6;

    /**
     * @var int
     *
     * @ORM\Column(name="numeric_domain", type="integer",options={"unsigned":true}, nullable=true)
     */
    protected $numeric_domain;

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
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Network\Host\Host",mappedBy="network", cascade={"persist"}))
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
