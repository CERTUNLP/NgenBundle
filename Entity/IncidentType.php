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
//use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * IncidentType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Entity\IncidentTypeRepository")
 * @JMS\ExclusionPolicy("all")
 */
class IncidentType {

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @JMS\Expose
     */
    private $name;

    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose 
     */
    private $slug;

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

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Model\IncidentInterface",mappedBy="type", cascade={"persist","remove"}, fetch="EAGER")) */
    private $incidents;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\IncidentReport",mappedBy="type",indexBy="lang", cascade={"persist","remove"}, fetch="EAGER")) 
     *
     *  @Assert\Count(
     *      min = 1,
     *      minMessage = "This type needs at least one report to be used",
     * )
     */
    private $reports;

    /**
     * Constructor
     */
    public function __construct() {
        $this->incidents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->getSlug();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return IncidentType
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
     * Set slug
     *
     * @param string $slug
     * @return IncidentType
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Network
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * Get evidence_file
     *
     * @return string 
     */
    public function getReportName() {
        return $this->getSlug() . ".md";
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Network
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Network
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Add incident
     *
     * @param \CertUnlp\NgenBundle\Entity\InternalIncident $incident
     *
     * @return IncidentType
     */
    public function addIncident(\CertUnlp\NgenBundle\Entity\InternalIncident $incident) {
        $this->incidents[] = $incident;

        return $this;
    }

    /**
     * Remove incident
     *
     * @param \CertUnlp\NgenBundle\Entity\InternalIncident $incident
     */
    public function removeIncident(\CertUnlp\NgenBundle\Entity\InternalIncident $incident) {
        $this->incidents->removeElement($incident);
    }

    /**
     * Get incidents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIncidents() {
        return $this->incidents;
    }

    /**
     * Add report
     *
     * @param \CertUnlp\NgenBundle\Entity\IncidentReport $report
     *
     * @return IncidentType
     */
    public function addReport(\CertUnlp\NgenBundle\Entity\IncidentReport $report) {
        $this->reports[] = $report;

        return $this;
    }

    /**
     * Remove report
     *
     * @param \CertUnlp\NgenBundle\Entity\IncidentReport $report
     */
    public function removeReport(\CertUnlp\NgenBundle\Entity\IncidentReport $report) {
        $this->reports->removeElement($report);
    }

    /**
     * Get reports
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReports() {
        return $this->reports;
    }

    /**
     * Get report
     *
     * @return \CertUnlp\NgenBundle\Entity\IncidentReport
     */
    public function getReport($lang = null) {
        return $this->reports->filter(function($report)use ($lang) {
                    return $report->getLang() == $lang;
                })->first();
    }

}
