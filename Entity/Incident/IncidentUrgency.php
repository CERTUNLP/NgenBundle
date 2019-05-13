<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use JMS\Serializer\Annotation as JMS;

/**
 * IncidentUrgency
 *
 * @ORM\Table(name="incident_urgency")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class IncidentUrgency implements Translatable
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     * @JMS\Expose
     * @Gedmo\Translatable
     */
    private $name;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @var string|null
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=45)
     * @JMS\Expose
     * */
    private $slug;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @JMS\Expose
     */
    private $description;


    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentPriority",mappedBy="urgency"))
     */

    private $incidentsPriorities;

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return Collection|null
     */
    public function getIncidents(): ?Collection
    {
        return $this->incidents;
    }

    /**
     * @param Collection|null $incidents
     * @return IncidentUrgency
     */
    public function setIncidents(?Collection $incidents): IncidentUrgency
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
     * @return IncidentUrgency
     */
    public function setName(string $name): IncidentUrgency
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
     * @return IncidentUrgency
     */
    public function setDescription(string $description): IncidentUrgency
    {
        $this->description = $description;
        return $this;
    }

    public function __toString()
    {
        return $this->getSlug();
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return IncidentUrgency
     */
    public function setSlug($slug): IncidentUrgency
    {
        $this->slug = $slug;

        return $this;
    }

}