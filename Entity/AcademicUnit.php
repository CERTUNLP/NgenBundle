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

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * AcademicUnit
 *
 * @ORM\Table()
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class AcademicUnit {

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
     * @ORM\Column(name="name", type="string", length=50)
     * @JMS\Expose
     */
    private $name;

    /**
     * @var string
     * 
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * */
    private $slug;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Network",mappedBy="academicUnit", cascade={"persist","remove"}, fetch="EAGER")) */
    private $networks;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Model\IncidentInterface",mappedBy="academicUnit", cascade={"persist","remove"}, fetch="EAGER")) */
    private $incidents;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    public function __toString() {
        return $this->getName();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return AcademicUnit
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Constructor
     */
    public function __construct($name) {
        $this->setName($name);
        $this->networks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add networks
     *
     * @param \CertUnlp\NgenBundle\Entity\Network $networks
     * @return AcademicUnit
     */
    public function addNetwork(\CertUnlp\NgenBundle\Entity\Network $networks) {
        $this->networks[] = $networks;

        return $this;
    }

    /**
     * Remove networks
     *
     * @param \CertUnlp\NgenBundle\Entity\Network $networks
     */
    public function removeNetwork(\CertUnlp\NgenBundle\Entity\Network $networks) {
        $this->networks->removeElement($networks);
    }

    /**
     * Get networks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNetworks() {
        return $this->networks;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return AcademicUnit
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Add incidents
     *
     * @param \CertUnlp\NgenBundle\Entity\Incident $incidents
     * @return AcademicUnit
     */
    public function addIncident(\CertUnlp\NgenBundle\Entity\Incident $incidents) {
        $this->incidents[] = $incidents;

        return $this;
    }

    /**
     * Remove incidents
     *
     * @param \CertUnlp\NgenBundle\Entity\Incident $incidents
     */
    public function removeIncident(\CertUnlp\NgenBundle\Entity\Incident $incidents) {
        $this->incidents->removeElement($incidents);
    }

    /**
     * Get incidents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIncidents() {
        return $this->incidents;
    }

}
