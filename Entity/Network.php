<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity;

use CertUnlp\NgenBundle\Model\IncidentInterface;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use CertUnlp\NgenBundle\Validator\Constraints as NetworkAssert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Network
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Entity\NetworkRepository")
 * @UniqueEntity(
 *     fields={"ip", "ipMask","isActive"},
 *     message="This network was already added!")
 * @JMS\ExclusionPolicy("all")
 */
class Network implements NetworkInterface
{

    /**
     * @var integer
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
     * @var string
     *
     * @ORM\Column(name="numeric_ip_mask", type="bigint", options={"unsigned":true})
     */
    private $numericIpMask;

    /**
     * @var string
     * @NetworkAssert\Ip
     * @ORM\Column(name="ip", type="string", length=40)
     * @JMS\Expose
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="numeric_ip", type="integer",options={"unsigned":true})
     */
    private $numericIp;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\NetworkAdmin", inversedBy="networks",cascade={"persist"})
     * @JMS\Expose
     */
    private $network_admin;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\AcademicUnit", inversedBy="networks",cascade={"persist"})
     * @JMS\Expose
     */
    private $academic_unit;

    /**
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Model\IncidentInterface",mappedBy="network", cascade={"persist","remove"}))
     * @JMS\Expose
     */
    private $incidents;

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

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\IncidentDecision",mappedBy="network", cascade={"persist","remove"})) */
    private $incidentsDecisions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->incidents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Network
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get network_admin
     *
     * @return NetworkAdmin
     */
    public function getNetworkAdmin()
    {
        return $this->network_admin;
    }

    /**
     * Set network_admin
     *
     * @param NetworkAdmin $network_admin
     * @return Network
     */
    public function setNetworkAdmin(NetworkAdmin $network_admin = null)
    {
        $this->network_admin = $network_admin;

        return $this;
    }

    /**
     * Get academic_unit
     *
     * @return AcademicUnit
     */
    public function getAcademicUnit()
    {
        return $this->academic_unit;
    }

    /**
     * Set academic_unit
     *
     * @param AcademicUnit $academic_unit
     * @return Network
     */
    public function setAcademicUnit(AcademicUnit $academic_unit = null)
    {
        $this->academic_unit = $academic_unit;

        return $this;
    }

    public function __toString()
    {
        return $this->getIpAndMask();
    }

    public function getIpAndMask()
    {
        return $this->getIp() . "/" . $this->getIpMask();
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Network
     */
    public function setIp($ip)
    {

        $ip_and_mask = explode('/', $ip);

        $this->ip = $ip_and_mask[0];
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
    public function getIpMask()
    {
        return $this->ipMask;
    }

    /**
     * Set ipMask
     *
     * @param string $ipMask
     * @return Network
     */
    public function setIpMask($ipMask)
    {
        $this->ipMask = $ipMask;
        $this->setNumericIpMask(0xffffffff << (32 - $ipMask));

        return $this;
    }

    /**
     * Add incidents
     *
     * @param \CertUnlp\NgenBundle\Model\IncidentInterface $incidents
     * @return Network
     */
    public function addIncident(IncidentInterface $incidents)
    {
        $this->incidents[] = $incidents;

        return $this;
    }

    /**
     * Remove incidents
     *
     * @param \CertUnlp\NgenBundle\Model\IncidentInterface $incidents
     */
    public function removeIncident(IncidentInterface $incidents)
    {
        $this->incidents->removeElement($incidents);
    }

    /**
     * Get incidents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIncidents()
    {
        return $this->incidents;
    }

    public function equals(NetworkInterface $other = null)
    {
        if ($other) {
            return ($this->getNumericIp() == $other->getNumericIp()) && ($this->getNumericIpMask() == $other->getNumericIpMask());
        } else {
            return false;
        }
    }

    /**
     * Get numericIp
     *
     * @return integer
     */
    public function getNumericIp()
    {
        return $this->numericIp;
    }

    /**
     * Set numericIp
     *
     * @param integer $numericIp
     * @return Network
     */
    public function setNumericIp($numericIp)
    {
        $this->numericIp = $numericIp;

        return $this;
    }

    /**
     * Get numericIpMask
     *
     * @return integer
     */
    public function getNumericIpMask()
    {
        return $this->numericIpMask;
    }

    /**
     * Set numericIpMask
     *
     * @param integer $numericIpMask
     * @return Network
     */
    public function setNumericIpMask($numericIpMask)
    {
        $this->numericIpMask = $numericIpMask;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Network
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Network
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
