<?php

namespace CertUnlp\NgenBundle\Entity\Incident\State\Behavior;

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;
use CertUnlp\NgenBundle\Entity\Incident\IncidentStateChange;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"closed" = "ClosedBehavior", "on_treatment" = "OnTreatmentBehavior", "new" = "NewBehavior", "discarded" = "DiscardedBehavior", "behavior" = "StateBehavior"})
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="This behvior already in exists."
 * )
 */
abstract class StateBehavior extends Entity
{

    /**
     * @var string|null
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=45)
     * @JMS\Expose()
     * @JMS\Groups({"read"})
     */
    protected $slug;
    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     * @JMS\Expose()
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $name;
    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState",mappedBy="behavior"))
     * @ORM\JoinColumn(name="states", referencedColumnName="slug")
     */
    private $states;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $canEdit = true;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $canEditFundamentals = true;
    /**
     * @var boolean
     * @ORM\Column( type="boolean")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $canEnrich = true;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $canAddHistory = true;
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $canComunicate = true;

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
     * @param IncidentStateChange $changeState
     * @return Incident
     */
    public function addStateChange(Incident $incident, IncidentStateChange $changeState): Incident
    {
        $incident->getStatechanges()->add($changeState);
        return $incident;
    }

    /**
     * @param Incident $incident
     * @param Incident $incident_detected
     * @return Incident
     */
    public function addIncidentDetected(Incident $incident, Incident $incident_detected): Incident
    {
        if ($this->canEnrich()) {
            $new_incident_detected = new IncidentDetected($incident_detected, $incident);
            $incident->getIncidentsDetected()->add($new_incident_detected);
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

    /**
     * @param Incident $incident
     * @param Incident $incidentDetected
     * @return Incident
     */
    public function updateTlp(Incident $incident, Incident $incidentDetected): Incident
    {
        return $incident;
    }

    /**
     * @param Incident $incident
     * @param Incident $incidentDetected
     * @return Incident
     * @throws Exception
     */
    public function updateDeadlines(Incident $incident, Incident $incidentDetected): Incident
    {
        $incident->setResponseDeadLine($incidentDetected->getResponseDeadLine());
        $incident->setSolveDeadLine($incidentDetected->getSolveDeadLine());
        return $incident;
    }

    /**
     * @param Incident $incident
     * @param Incident $incidentDetected
     * @return Incident
     */
    public function updatePriority(Incident $incident, Incident $incidentDetected): Incident
    {
        return $incident;
    }

    /**
     * @return bool
     */
    abstract public function isAttended(): bool;

    /**
     * @return bool
     */
    abstract public function isSolved(): bool;

    /**
     * @return bool
     */
    abstract public function isAddressed(): bool;

    /**
     * @return bool
     */
    abstract public function isLive(): bool;

    /**
     * @return bool
     */
    abstract public function isDead(): bool;

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
}
