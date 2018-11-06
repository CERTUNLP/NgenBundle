<?php

namespace CertUnlp\NgenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Tlp
 *
 * @ORM\Table(name="tlp")
 * @ORM\Entity
 */
class Tlp
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
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Tlp
     */
    public function setName(string $name): Tlp
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
     * @return Tlp
     */
    public function setRgb(string $rgb): Tlp
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
     * @return Tlp
     */
    public function setWhen(string $when): Tlp
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
     * @return Tlp
     */
    public function setEncrypt(bool $encrypt): Tlp
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
     * @return Tlp
     */
    public function setWhy(string $why): Tlp
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
     * @return Tlp
     */
    public function setInformation(string $information): Tlp
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
     * @return Tlp
     */
    public function setDescription(string $description): Tlp
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
     * @return Tlp
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

}
