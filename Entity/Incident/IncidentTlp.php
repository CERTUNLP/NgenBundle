<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * IncidentTlp
 *
 * @ORM\Table(name="incident_tlp")
 * @ORM\Entity
 */
class IncidentTlp
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=45)
     * */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="rgb", type="string", length=45, nullable=true)
     */
    private $rgb;

    /**
     * @var string
     *
     * @ORM\Column(name="when", type="string", length=500, nullable=true)
     */
    private $when;

    /**
     * @var boolean
     *
     * @ORM\Column(name="encrypt", type="boolean", nullable=true)
     */
    private $encrypt;

    /**
     * @var string
     *
     * @ORM\Column(name="why", type="string", length=500, nullable=true)
     */
    private $why;

    /**
     * @var string
     *
     * @ORM\Column(name="information", type="string", length=10, nullable=true)
     */
    private $information;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=150, nullable=true)
     */
    private $description;


    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Model\IncidentInterface",mappedBy="tlp", cascade={"persist","remove"})) */
    private $incidents;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->incidents = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function __toString()
    {
        return strtoupper($this->slug);
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
