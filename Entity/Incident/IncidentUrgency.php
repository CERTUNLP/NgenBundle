<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\EntityApiFrontend;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use JMS\Serializer\Annotation as JMS;

/**
 * IncidentUrgency
 *
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class IncidentUrgency extends EntityApiFrontend implements Translatable
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     * @JMS\Expose
     * @Gedmo\Translatable
     */
    private $name = '';

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=45)
     * @JMS\Expose
     * */
    protected $slug = '';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @JMS\Expose
     */
    private $description = '';


    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentPriority",mappedBy="urgency"))
     */
    private $incidentsPriorities = null;

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     * @return IncidentUrgency
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getIncidentsPriorities(): ?Collection
    {
        return $this->incidentsPriorities;
    }

    /**
     * @param Collection|null $incidentsPriorities
     * @return IncidentUrgency
     */
    public function setIncidentsPriorities(?Collection $incidentsPriorities): IncidentUrgency
    {
        $this->incidentsPriorities = $incidentsPriorities;
        return $this;
    }

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

    /**
     * @return string
     */
    public function __toString(): string
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

    /**
     * @return string
     */
    public function getIdentificatorString(): string
    {
        return 'slug';
    }
}