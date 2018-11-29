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

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * NetworkAdmin
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\NetworkAdminRepository")
 * @JMS\ExclusionPolicy("all")
 */
class NetworkAdmin
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
     * @ORM\Column(name="name", type="string", length=100)
     * @JMS\Expose()
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name","email"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true,unique=true)
     * */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150)
     * @JMS\Expose()
     */
    private $email;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Network\Network",mappedBy="network_admin", cascade={"persist","remove"})) */
    private $networks;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Model\IncidentInterface",mappedBy="network_admin", cascade={"persist","remove"})) */
    private $incidents;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose()
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
     * @param null $name
     * @param null $email
     */
    public function __construct($name = null, $email = null)
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->networks = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add networks
     *
     * @param Network $networks
     * @return NetworkAdmin
     */
    public function addNetwork(Network $networks)
    {
        $this->networks[] = $networks;

        return $this;
    }

    /**
     * Remove networks
     *
     * @param Network $networks
     */
    public function removeNetwork(Network $networks)
    {
        $this->networks->removeElement($networks);
    }

    /**
     * Get networks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNetworks()
    {
        return $this->networks;
    }

    public function __toString()
    {
        return $this->getName() . " (" . $this->getEmail() . ")";
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return NetworkAdmin
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return NetworkAdmin
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return NetworkAdmin
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
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
     * @return NetworkAdmin
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Add incidents
     *
     * @param \CertUnlp\NgenBundle\Model\IncidentInterface $incidents
     * @return NetworkAdmin
     */
    public function addIncident(\CertUnlp\NgenBundle\Model\IncidentInterface $incidents)
    {
        $this->incidents[] = $incidents;

        return $this;
    }

    /**
     * Remove incidents
     *
     * @param \CertUnlp\NgenBundle\Model\IncidentInterface $incidents
     */
    public function removeIncident(\CertUnlp\NgenBundle\Model\IncidentInterface $incidents)
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
     * @return NetworkAdmin
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
     * @return NetworkAdmin
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
