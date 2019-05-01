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
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     * @JMS\Expose
     */
    private $name;

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
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     * @JMS\Expose
     */
    private $description;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState",mappedBy="incident_action"))
     * @JMS\Exclude()
     */
    private $incident_state;
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
     * @return IncidentState
     */
    public function getIncidentState(): IncidentState
    {
        return $this->incident_state;
    }

    /**
     * @param IncidentState $incident_state
     */
    public function setIncidentState(IncidentState $incident_state): void
    {
        $this->incident_state = $incident_state;
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
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return IncidentStateAction
     */
    public function setSlug(string $slug): IncidentStateAction
    {
        $this->slug = $slug;

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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
