<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Entity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use JMS\Serializer\Annotation as JMS;

/**
 * IncidentImpact
 *
 * @ORM\Table(name="incident_impact")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class IncidentImpact extends Entity implements Translatable
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string")
     * @JMS\Expose()
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
     * @JMS\Expose()
     * */
    private $slug;
    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=512, nullable=true)
     * @JMS\Expose()
     */
    private $description;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentPriority",mappedBy="impact"))
     */
    private $incidentsPriorities;

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
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

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'list-ol';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        switch ($this->getSlug()) {
            case 'high':
                return 'danger';
                break;
            case 'medium':
                return 'warning';
                break;
            case 'low':
                return 'primary';
                break;
            default:
                return 'info';
        }
    }

}