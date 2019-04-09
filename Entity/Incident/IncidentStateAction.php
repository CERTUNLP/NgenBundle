<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;


/**
 * IncidentTlp
 *
 * @ORM\Table(name="incident_state_action")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */

class IncidentStateAction
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     * @JMS\Expose
     */
    private $name;

    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=45)
     * @JMS\Expose
     * */
    private $slug;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     * @JMS\Expose
     */
    private $description;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState",mappedBy="incident_action"))
     * @JMS\Exclude()
     */
    private $incident_state;

    /**
     * @return mixed
     */
    public function getIncidentState()
    {
        return $this->incident_state;
    }

    /**
     * @param mixed $incident_state
     */
    public function setIncidentState($incident_state): void
    {
        $this->incidnet_state = $incident_state;
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
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="open", type="boolean")
     * @JMS\Expose
     */
    private $open = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="close", type="boolean")
     * @JMS\Expose
     */
    private $close = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="re_open", type="boolean")
     * @JMS\Expose
     */
    private $reOpen = false;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->open;
    }

    /**
     * @param bool $open
     */
    public function setOpen(bool $open): void
    {
        $this->open = $open;
    }

    /**
     * @return bool
     */
    public function isClose(): bool
    {
          return $this->close;
    }

    /**
     * @param bool $close
     */
    public function setClose(bool $close): void
    {
        $this->close = $close;
    }

    /**
     * @return bool
     */
    public function isReOpen(): bool
    {
        return $this->reOpen;
    }

    /**
     * @param bool $reOpen
     */
    public function setReOpen(bool $reOpen): void
    {
        $this->reOpen = $reOpen;
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
