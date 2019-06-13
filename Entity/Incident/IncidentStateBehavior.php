<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;


/**
 * IncidentTlp
 *
 * @ORM\Table(name="incident_state_behavior")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class IncidentStateBehavior
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

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState",mappedBy="incident_state_behavior"))
     * @ORM\JoinColumn(name="states", referencedColumnName="slug")
     * @JMS\Exclude()
     */
    private $states;

    /**
     * @var boolean
     *
     * @ORM\Column( type="boolean")
     * @JMS\Expose
     */
    private $canOpen = false;

    /**
     * @var boolean
     *
     * @ORM\Column( type="boolean")
     * @JMS\Expose
     */
    private $canClose = false;

    /**
     * @var boolean
     *
     * @ORM\Column( type="boolean")
     * @JMS\Expose
     */
    private $canReOpen = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;

    /**
     * @var DateTime|null
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var DateTime|null
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;


    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @JMS\Expose
     */
    private $canEdit = true;

    /**
     * @var boolean
     *
     * @ORM\Column( type="boolean")
     * @JMS\Expose
     */
    private $canEnrich = true;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @JMS\Expose
     */
    private $canAddHistory = true;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @JMS\Expose
     */
    private $canComunicate = true;


    public function __construct()
    {
        $this->states = new ArrayCollection();
    }

    /**
     * @return bool
     */
    public function isCanComunicate(): bool
    {
        return $this->canComunicate;
    }

    /**
     * @param bool $canComunicate
     * @return IncidentStateBehavior
     */
    public function setCanComunicate(bool $canComunicate): self
    {
        $this->canComunicate = $canComunicate;
        return $this;
    }

    /**
     * @return IncidentState[]|Collection
     */
    public function getStates(): Collection
    {
        return $this->states;
    }


    /**
     * @param IncidentState $states
     * @return IncidentStateBehavior
     */
    public function setStates(IncidentState $states): self
    {
        $this->states = $states;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCanEdit(): bool
    {
        return $this->canEdit;
    }

    /**
     * @param bool $canEdit
     * @return IncidentStateBehavior
     */
    public function setCanEdit(bool $canEdit): self
    {
        $this->canEdit = $canEdit;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCanEnrich(): bool
    {
        return $this->canEnrich;
    }

    /**
     * @param bool $canEnrich
     * @return IncidentStateBehavior
     */
    public function setCanEnrich(bool $canEnrich): self
    {
        $this->canEnrich = $canEnrich;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCanAddHistory(): bool
    {
        return $this->canAddHistory;
    }

    /**
     * @param bool $canAddHistory
     * @return IncidentStateBehavior
     */
    public function setCanAddHistory(bool $canAddHistory): self
    {
        $this->canAddHistory = $canAddHistory;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return IncidentStateBehavior
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return IncidentStateBehavior
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return IncidentStateBehavior
     */
    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return IncidentStateBehavior
     */
    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
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
    public function isCanOpen(): bool
    {
        return $this->canOpen;
    }

    /**
     * @param bool $canOpen
     */
    public function setCanOpen(bool $canOpen): void
    {
        $this->canOpen = $canOpen;
    }

    /**
     * @return bool
     */
    public function isCanClose(): bool
    {
        return $this->canClose;
    }

    /**
     * @param bool $canClose
     */
    public function setCanClose(bool $canClose): void
    {
        $this->canClose = $canClose;
    }

    /**
     * @return bool
     */
    public function isCanReOpen(): bool
    {
        return $this->canReOpen;
    }

    /**
     * @param bool $canReOpen
     */
    public function setCanReOpen(bool $canReOpen): void
    {
        $this->canReOpen = $canReOpen;
    }
}
