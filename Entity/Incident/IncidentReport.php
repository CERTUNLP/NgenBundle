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

use CertUnlp\NgenBundle\Entity\EntityApiFrontend;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * IncidentReport
 *
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Incident\IncidentReportRepository")
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"lang", "type"},
 *     errorPath="lang",
 *     message="This lang is already in use on that type."
 * )
 */
class IncidentReport extends EntityApiFrontend
{
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
     * @ORM\Column(length=64, unique=true)
     * @JMS\Expose
     * @JMS\Groups({"read"})
     */
    protected $slug;
    /**
     * @var string
     * @ORM\Column(name="lang", type="string", length=2)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $lang = '';
    /**
     * @var IncidentType|null
     *
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType",inversedBy="reports")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $type;
    /**
     * @var string
     *
     * @ORM\Column(name="problem", type="text")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $problem = '';
    /**
     * @var string
     *
     * @ORM\Column(name="derivated_problem", type="text",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $derivated_problem = '';
    /**
     * @var string
     *
     * @ORM\Column(name="verification", type="text",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $verification = '';
    /**
     * @var string
     *
     * @ORM\Column(name="recomendations", type="text",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $recomendations = '';
    /**
     * @var string
     *
     * @ORM\Column(name="more_information", type="text",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $more_information = '';

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

    public function __toString(): string
    {
        return $this->getType()->getName() . '/' . $this->getLang();
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
     * @return string
     */
    public function getProblem(): ?string
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
    public function getRecomendations(): ?string
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
     * @return string
     */
    public function getIdentificationString(): string
    {
        return 'slug';
    }

    /**
     * {@inheritDoc}
     */
    public function getDataIdentificationArray(): array
    {
        return ['lang' => $this->getLang(), 'type' => $this->getType()->getId()];
    }
}
