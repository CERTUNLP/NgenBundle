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
use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

//use Doctrine\Common\Collections\Collection;

/**
 * IncidentType
 *
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IncidentTypeRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This type is already in use."
 * )
 * @JMS\ExclusionPolicy("all")
 */
class IncidentType extends EntityApiFrontend
{
    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     */
    protected $slug;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @JMS\Expose
     */
    private $name;
    /**
     * @var boolean
     * @ORM\Column(name="is_Classification", type="boolean")
     * @JMS\Expose
     */
    private $isClassification = false;
    /**
     * @var Collection | Incident[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="type",fetch="EXTRA_LAZY")
     */
    private $incidents;
    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     * @JMS\Expose
     */
    private $description;
    /**
     * @var Collection | IncidentReport[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentReport",mappedBy="type",indexBy="lang"))
     */
    private $reports;
    /**
     * @var TaxonomyValue|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue")
     * @ORM\JoinColumn(name="taxonomyValue", referencedColumnName="slug",nullable=true)
     **/
    private $taxonomyValue;

    /**
     * IncidentType constructor.
     */
    public function __construct()
    {
        $this->incidents = new ArrayCollection();
        $this->setTaxonomyValue(null);
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'cubes';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'info';
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return IncidentType
     */
    public function setName(string $name): IncidentType
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get report
     *
     * @param string $lang
     * @return IncidentReport
     */
    public function getReport(string $lang = null): IncidentReport
    {
        $reporte = $this->getReports()->filter(
            static function (IncidentReport $report) use ($lang) {
                return $report->getLang() === $lang;
            }
        )->first();
        if ($reporte) {
            return $reporte;
        }

        if ($this->getTaxonomyValue()) {
            return $this->getTaxonomyValue()->getReport();
        }

        return $this->getTaxonomyValue()->getPredicate()->getReport();
    }

    /**
     * @return IncidentReport[]|Collection
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    /**
     * @param IncidentReport[]|Collection $reports
     * @return IncidentType
     */
    public function setReports(Collection $reports): self
    {
        $this->reports = $reports;
        return $this;
    }

    /**
     * @return TaxonomyValue
     */
    public function getTaxonomyValue(): ?TaxonomyValue
    {
        return $this->taxonomyValue;
    }

    /**
     * @param TaxonomyValue $taxonomyValue
     * @return IncidentType
     */
    public function setTaxonomyValue(TaxonomyValue $taxonomyValue): IncidentType
    {
        $this->taxonomyValue = $taxonomyValue;
        return $this;
    }

    /**
     * Get incidents
     *
     * @param string $type
     * @return Collection
     */
    public function getliveIncidentsOfType(string $type): Collection
    {
        return $this->getliveIncidents()->filter(static function (Incident $incident) use ($type) {
            return $incident->getType()->getSlug() === $type;
        });
    }

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getliveIncidents(): Collection
    {
        return $this->getIncidents()->filter(static function (Incident $incident) {
            return $incident->isLive();
        });
    }

    /**
     * @return Incident[]|Collection
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    /**
     * @param Incident[]|Collection $incidents
     * @return IncidentType
     */
    public function setIncidents(Collection $incidents): self
    {
        $this->incidents = $incidents;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return IncidentType
     */
    public function setSlug(string $slug): IncidentType
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): IncidentType
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isClassification(): bool
    {
        return $this->isClassification;
    }

    /**
     * @param bool $isClassification
     */
    public function setIsClassification(bool $isClassification): void
    {
        $this->isClassification = $isClassification;
    }

    /**
     * @return string
     */
    public function getIdentificatorString(): string
    {
        return 'slug';
    }
}
