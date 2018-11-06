<?php

namespace CertUnlp\NgenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tlp
 *
 * @ORM\Table(name="tlp")
 * @ORM\Entity
 */
class Tlp
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idtlp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtlp;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=45, nullable=true)
     */
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

    public function __toString()
    {
        return $this->name;
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
     * @return IncidentState
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

}
