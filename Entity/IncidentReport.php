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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * IncidentReport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Entity\IncidentReportRepository")
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"lang", "type"},
 *     errorPath="lang",
 *     message="This lang is already in use on that type."
 * )
 */
class IncidentReport
{

    /**
     * @var boolean
     * @ORM\Column(name="lang", type="string", length=2)
     * @JMS\Expose
     */
    private $lang = '';

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentType",inversedBy="reports")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     */
    private $type;

    /**
     * Person domain object class
     * @ORM\id
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\RelativeSlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="relationField", value="type"),
     *          @Gedmo\SlugHandlerOption(name="relationSlugField", value="slug"),
     *          @Gedmo\SlugHandlerOption(name="separator", value="-")
     *      })
     * }, fields={"lang"})
     * @Doctrine\ORM\Mapping\Column(length=64, unique=true)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="problem", type="text")
     * @JMS\Expose
     */
    private $problem = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="derivated_problem", type="text",nullable=true)
     * @JMS\Expose
     */
    private $derivated_problem = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="verification", type="text",nullable=true)
     * @JMS\Expose
     */
    private $verification = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="recomendations", type="text",nullable=true)
     * @JMS\Expose
     */
    private $recomendations = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="more_information", type="text",nullable=true)
     * @JMS\Expose
     */
    private $more_information = '';

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

    public function __toString()
    {
        return $this->getType() . "/" . $this->getLang();
    }

    /**
     * Get type
     *
     * @return IncidentType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param IncidentType $type
     *
     * @return IncidentReport
     */
    public function setType(IncidentType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

//    /**
//     * Set slug
//     *
//     * @param string $slug
//     * @return IncidentReport
//     */
//    public function setSlug($slug) {
//        $this->slug = $slug;
//
//        return $this;
//    }
//
//    /**
//     * Get slug
//     *
//     * @return string
//     */
//    public function getSlug() {
//        return $this->slug;
//    }

    /**
     * Set lang
     *
     * @param string $lang
     *
     * @return IncidentReport
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->lang;
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
     * @return IncidentReport
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get evidence_file
     *
     * @return string
     */
    public function getReportName()
    {
        return $this->getSlug() . ".md";
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
     *
     * @return IncidentReport
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

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
     * @return IncidentReport
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
     * @return IncidentReport
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get problem
     *
     * @return string
     */
    public function getProblem()
    {
        return $this->problem;
    }

    /**
     * Set problem
     *
     * @param string $problem
     *
     * @return IncidentReport
     */
    public function setProblem($problem)
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Get derivatedProblem
     *
     * @return string
     */
    public function getDerivatedProblem()
    {
        return $this->derivated_problem;
    }

    /**
     * Set derivatedProblem
     *
     * @param string $derivatedProblem
     *
     * @return IncidentReport
     */
    public function setDerivatedProblem($derivatedProblem)
    {
        $this->derivated_problem = $derivatedProblem;

        return $this;
    }

    /**
     * Get verification
     *
     * @return string
     */
    public function getVerification()
    {
        return $this->verification;
    }

    /**
     * Set verification
     *
     * @param string $verification
     *
     * @return IncidentReport
     */
    public function setVerification($verification)
    {
        $this->verification = $verification;

        return $this;
    }

    /**
     * Get recomendations
     *
     * @return string
     */
    public function getRecomendations()
    {
        return $this->recomendations;
    }

    /**
     * Set recomendations
     *
     * @param string $recomendations
     *
     * @return IncidentReport
     */
    public function setRecomendations($recomendations)
    {
        $this->recomendations = $recomendations;

        return $this;
    }

    /**
     * Get moreInformation
     *
     * @return string
     */
    public function getMoreInformation()
    {
        return $this->more_information;
    }

    /**
     * Set moreInformation
     *
     * @param string $moreInformation
     *
     * @return IncidentReport
     */
    public function setMoreInformation($moreInformation)
    {
        $this->more_information = $moreInformation;

        return $this;
    }

}
