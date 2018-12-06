<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * IncidentImpact
 *
 * @ORM\Table(name="incident_impact")
 * @ORM\Entity
 */
class IncidentImpact
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=45)
     * */
    private $slug;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=512, nullable=true)
     */
    private $description;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="impact", cascade={"persist"}))
     */
    private $incidents;

    /**
     * @return Collection
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    /**
     * @param Collection $incidents
     * @return IncidentImpact
     */
    public function setIncidents(Collection $incidents): IncidentImpact
    {
        $this->incidents = $incidents;
        return $this;
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
     * @return IncidentTlp
     */
    public function setName(string $name): IncidentTlp
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return IncidentTlp
     */
    public function setDescription(string $description): IncidentTlp
    {
        $this->description = $description;
        return $this;
    }

    public function __toString()
    {
        return $this->slug;
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
     * @return IncidentTlp
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

}