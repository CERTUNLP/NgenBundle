<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * IncidentReport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IncidentReportRepository")
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
     * @var string
     * @ORM\Column(name="lang", type="string", length=2)
     * @JMS\Expose
     */
    private $lang = '';

    /**
     * @var IncidentType|null
     *
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType",inversedBy="reports")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     */
    private $type;

    /**
     * @var string|null
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
     * @var string
     *
     * @ORM\Column(name="problem", type="text")
     * @JMS\Expose
     */
    private $problem = '';

    /**
     * @var string
     *
     * @ORM\Column(name="derivated_problem", type="text",nullable=true)
     * @JMS\Expose
     */
    private $derivated_problem = '';

    /**
     * @var string
     *
     * @ORM\Column(name="verification", type="text",nullable=true)
     * @JMS\Expose
     */
    private $verification = '';

    /**
     * @var string
     *
     * @ORM\Column(name="recomendations", type="text",nullable=true)
     * @JMS\Expose
     */
    private $recomendations = '';

    /**
     * @var string
     *
     * @ORM\Column(name="more_information", type="text",nullable=true)
     * @JMS\Expose
     */
    private $more_information = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;

    /**
     * @var DateTime|null
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var DateTime|null
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;

    public function __toString(): string
    {
        return $this->getType() . '/' . $this->getLang();
    }

    /**
     * @return IncidentType|null
     */
    public function getType(): ?IncidentType
    {
        return $this->type;
    }

    /**
     * @param IncidentType|null $type
     * @return IncidentReport
     */
    public function setType(?IncidentType $type): IncidentReport
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return IncidentReport
     */
    public function setLang(string $lang): IncidentReport
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'newspaper';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'info';
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->getSlug();
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return IncidentReport
     */
    public function setSlug(?string $slug): IncidentReport
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getProblem(): string
    {
        return $this->problem;
    }

    /**
     * @param string $problem
     * @return IncidentReport
     */
    public function setProblem(string $problem): IncidentReport
    {
        $this->problem = $problem;
        return $this;
    }

    /**
     * @return string
     */
    public function getDerivatedProblem(): ?string
    {
        return $this->derivated_problem;
    }

    /**
     * @param string $derivated_problem
     * @return IncidentReport
     */
    public function setDerivatedProblem(string $derivated_problem): IncidentReport
    {
        $this->derivated_problem = $derivated_problem;
        return $this;
    }

    /**
     * @return string
     */
    public function getVerification(): ?string
    {
        return $this->verification;
    }

    /**
     * @param string $verification
     * @return IncidentReport
     */
    public function setVerification(string $verification): IncidentReport
    {
        $this->verification = $verification;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecomendations(): string
    {
        return $this->recomendations;
    }

    /**
     * @param string $recomendations
     * @return IncidentReport
     */
    public function setRecomendations(string $recomendations): IncidentReport
    {
        $this->recomendations = $recomendations;
        return $this;
    }

    /**
     * @return string
     */
    public function getMoreInformation(): ?string
    {
        return $this->more_information;
    }

    /**
     * @param string $more_information
     * @return IncidentReport
     */
    public function setMoreInformation(string $more_information): IncidentReport
    {
        $this->more_information = $more_information;
        return $this;
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
     * @return IncidentReport
     */
    public function setIsActive(bool $isActive): IncidentReport
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return IncidentReport
     */
    public function setCreatedAt(?DateTime $createdAt): IncidentReport
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return IncidentReport
     */
    public function setUpdatedAt(?DateTime $updatedAt): IncidentReport
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


}
