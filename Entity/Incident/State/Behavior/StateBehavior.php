<?php

namespace CertUnlp\NgenBundle\Entity\Incident\State\Behavior;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentChangeState;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;


/**
 * IncidentTlp
 *
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"closed" = "ClosedBehavior", "on_treatment" = "OnTreatmentBehavior", "new" = "NewBehavior", "discarded" = "DiscardedBehavior", "behavior" = "StateBehavior"})
 * @JMS\ExclusionPolicy("all")
 */
abstract class StateBehavior
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

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState",mappedBy="incident_state_behavior"))
     * @ORM\JoinColumn(name="states", referencedColumnName="slug")
     * @JMS\Exclude()
     */
    private $states;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;

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
     * @ORM\Column(type="boolean")
     * @JMS\Expose
     */
    private $canEditFundamentals = true;
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

    public function __construct()
    {
        $this->states = new ArrayCollection();
    }

    /**
     * @return bool
     */
    public function isCanEditFundamentals(): bool
    {
        return $this->canEditFundamentals;
    }

    /**
     * @param bool $canEditFundamentals
     * @return StateBehavior
     */
    public function setCanEditFundamentals(bool $canEditFundamentals): StateBehavior
    {
        $this->canEditFundamentals = $canEditFundamentals;
        return $this;
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
     * @return StateBehavior
     */
    public function setCanComunicate(bool $canComunicate): self
    {
        $this->canComunicate = $canComunicate;
        return $this;
    }

    /**
     * @return bool
     */
    public function canComunicate(): bool
    {
        return $this->canComunicate;
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
     * @return StateBehavior
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
     * @return StateBehavior
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
     * @return StateBehavior
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
     * @return StateBehavior
     */
    public function setCanAddHistory(bool $canAddHistory): self
    {
        $this->canAddHistory = $canAddHistory;
        return $this;
    }

    /**
     * @return bool
     */
    public function canAddHistory(): bool
    {
        return $this->canAddHistory;
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
     * @return StateBehavior
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
     * @return StateBehavior
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
     * @return StateBehavior
     */
    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
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
     * @param Incident $incident
     * @param IncidentChangeState $changeState
     * @return Incident
     */
    public function addChangeStateHistory(Incident $incident, IncidentChangeState $changeState): Incident
    {
//        if ($this->canEnrich()) {
//        var_dump($changeState->getId());
        $incident->getChangeStateHistory()->add($changeState);
//        }

        return $incident;
    }

    /**
     * @param Incident $incident
     * @param Incident $incidentDetected
     * @return Incident
     */
    public function addIncidentDetected(Incident $incident, Incident $incidentDetected): Incident
    {
        if ($this->canEnrich()) {
            $nuevo = new IncidentDetected($incidentDetected, $incident);
            $incident->getIncidentsDetected()->add($nuevo);
            $incident->increaseLtdCount();
        }
        return $incident;
    }

    /**
     * @return bool
     */
    public function canEnrich(): bool
    {
        return $this->canEnrich;
    }

    /**
     * @param $property
     * @param $value
     * @param bool $fundamental
     * @return bool
     */
    public function setter(&$property, $value, bool $fundamental = false): bool
    {
        if ($property) {
            if ($this->canEdit()) {
                if ($fundamental && !$this->canEditFundamentals()) {
                    return false;
                }
                $property = $value;
                return true;
            }
            return false;
        }
        $property = $value;
        return true;
    }

    /**
     * @return bool
     */
    public function canEdit(): bool
    {
        return $this->canEdit;
    }

    /**
     * @return bool
     */
    public function canEditFundamentals(): bool
    {
        return $this->canEditFundamentals;
    }

    public function updateTlp(Incident $incident, Incident $incidentDetected): Incident
    {
        return $incident;
    }


    public function updatePriority(Incident $incident, Incident $incidentDetected): Incident
    {
        return $incident;
    }

    /**
     * @param Incident $incident
     * @return int
     * @throws Exception
     */
    public function getNewMinutes(Incident $incident): int
    {
        return 0;
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
     * @return StateBehavior
     */
    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    abstract public function isAttended(): bool;

    abstract public function isResolved(): bool;

    abstract public function isAddressed(): bool;

    abstract public function isLive(): bool;

    abstract public function isDead(): bool;

}
