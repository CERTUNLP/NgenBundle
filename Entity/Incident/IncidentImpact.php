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
     * @ORM\Column(name="name", type="string")
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
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="impact"))
     */
    private $incidents;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentDecision",mappedBy="impact")) */
    private $decisions;

    /**
     * @return mixed
     */
    public function getDecisions(): IncidentDecision
    {
        return $this->decisions;
    }

    /**
     * @param mixed $decisions
     * @return IncidentImpact
     */
    public function setDecisions(IncidentDecision $decisions)
    {
        $this->decisions = $decisions;
        return $this;
    }

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
     * @return IncidentImpact
     */
    public function setName(string $name): IncidentImpact
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
     * @return IncidentImpact
     */
    public function setDescription(string $description): IncidentImpact
    {
        $this->description = $description;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getSlug();
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return IncidentImpact
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;

        return $this;
    }

}