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

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue;
use DateTime;
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
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IncidentTypeRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This type is already in use."
 * )
 * @JMS\ExclusionPolicy("all")
 */
class IncidentType extends Entity
{
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
     * @var boolean
     * @ORM\Column(name="is_Classification", type="boolean")
     * @JMS\Expose
     */
    private $isClassification = false;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;

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
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Report\IncidentReport",mappedBy="type",indexBy="lang"))
     */
    private $reports;


    /**
     * @var TaxonomyValue
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue")
     * @ORM\JoinColumn(name="taxonomyValue", referencedColumnName="slug",nullable=true)
     **/
    private $taxonomyValue;


    /**
     * Constructor
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
     * Get id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->getSlug();
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
    public function getReport(string $lang = null)
    {
        $reporte = $this->getReports()->filter(
            static function (IncidentReport $report) use ($lang) {
                return $report->getLang() === $lang;
            }
        )->first();
        if ($reporte) {
            return $reporte;
        } else {
               if ($this->getTaxonomyValue()){
               return $this->getTaxonomyValue()->getReport();
               }
               else{

               }
            }
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
     * @return mixed
     */
    public function getTaxonomyValue(): ?TaxonomyValue
    {
        return $this->taxonomyValue;
    }

    /**
     * @param mixed $taxonomyValue
     */
    public function setTaxonomyValue($taxonomyValue = null): void
    {
        $this->taxonomyValue = $taxonomyValue;
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
     * @return bool
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
     * @return IncidentType
     */
    public function setIsActive(bool $isActive): IncidentType
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return IncidentType
     */
    public function setCreatedAt(DateTime $createdAt): IncidentType
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /*
    * @param string|null $description
    * @return IncidentType
    */

    /**
     * @param DateTime $updatedAt
     * @return IncidentType
     */
    public function setUpdatedAt(DateTime $updatedAt): IncidentType
    {
        $this->updatedAt = $updatedAt;
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


}
