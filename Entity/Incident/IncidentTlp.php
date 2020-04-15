<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use JMS\Serializer\Annotation as JMS;


/**
 * IncidentTlp
 *
 * @ORM\Table(name="incident_tlp")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class IncidentTlp extends Entity implements Translatable
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
     * @var integer
     *
     * @ORM\Column(name="code", type="integer", nullable=true)
     * @JMS\Expose
     */
    private $code = 0;
    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=45)
     * @JMS\Expose
     * */
    private $slug = '';
    /**
     * @var string
     *
     * @ORM\Column(name="rgb", type="string", length=45, nullable=true)
     */
    private $rgb = '';
    /**
     * @var string
     *
     * @ORM\Column(name="when", type="string", length=500, nullable=true)
     * @JMS\Expose
     */
    private $when = '';
    /**
     * @var boolean
     *
     * @ORM\Column(name="encrypt", type="boolean", nullable=true)
     */
    private $encrypt = false;
    /**
     * @var string
     *
     * @ORM\Column(name="why", type="string", length=500, nullable=true)
     * @JMS\Expose
     */
    private $why = '';
    /**
     * @var string
     *
     * @ORM\Column(name="information", type="string", length=10, nullable=true)
     * @JMS\Expose
     */
    private $information = '';
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=150, nullable=true)
     * @JMS\Expose
     */
    private $description = '';

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="tlp",fetch="EXTRA_LAZY")
     * @JMS\Exclude()
     */
    private $incidents;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->incidents = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'traffic-light';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        switch ($this->getCode()) {
            case 0:
                return 'white';
                break;
            case 1:
                return 'success';
                break;
            case 2:
                return 'warning';
                break;
            case 3:
                return 'danger';
                break;
            default:
                return 'info';
        }
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getRgb(): string
    {
        return $this->rgb;
    }

    /**
     * @param string $rgb
     * @return IncidentTlp
     */
    public function setRgb(string $rgb): IncidentTlp
    {
        $this->rgb = $rgb;
        return $this;
    }

    /**
     * @return string
     */
    public function getWhen(): string
    {
        return $this->when;
    }

    /**
     * @param string $when
     * @return IncidentTlp
     */
    public function setWhen(string $when): IncidentTlp
    {
        $this->when = $when;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEncrypt(): bool
    {
        return $this->encrypt;
    }

    /**
     * @param bool $encrypt
     * @return IncidentTlp
     */
    public function setEncrypt(bool $encrypt): IncidentTlp
    {
        $this->encrypt = $encrypt;
        return $this;
    }

    /**
     * @return string
     */
    public function getWhy(): string
    {
        return $this->why;
    }

    /**
     * @param string $why
     * @return IncidentTlp
     */
    public function setWhy(string $why): IncidentTlp
    {
        $this->why = $why;
        return $this;
    }

    /**
     * @return string
     */
    public function getInformation(): string
    {
        return $this->information;
    }

    /**
     * @param string $information
     * @return IncidentTlp
     */
    public function setInformation(string $information): IncidentTlp
    {
        $this->information = $information;
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
     * @return IncidentTlp
     */
    public function setName(string $name): IncidentTlp
    {
        $this->name = $name;
        return $this;
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
     * @return IncidentTlp
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return ArrayCollection
     */
    public function getIncidents(): ArrayCollection
    {
        return $this->incidents;
    }

    /**
     * @param ArrayCollection $incidents
     * @return IncidentTlp
     */
    public function setIncidents(ArrayCollection $incidents): IncidentTlp
    {
        $this->incidents = $incidents;
        return $this;
    }

}
