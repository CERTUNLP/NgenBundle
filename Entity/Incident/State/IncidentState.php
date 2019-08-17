<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident\State;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentChangeState;
use CertUnlp\NgenBundle\Entity\Incident\State\Behavior\StateBehavior;
use CertUnlp\NgenBundle\Entity\Incident\State\Edge\StateEdge;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use JMS\Serializer\Annotation as JMS;

/**
 * Description of IncidentClosingType
 *
 * @author dam
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IncidentStateRepository")
 * @JMS\ExclusionPolicy("all")
 */
class IncidentState implements Translatable
{
    /**
     * @var StateBehavior
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\Behavior\StateBehavior", inversedBy="states")
     * @ORM\JoinColumn(name="behavior", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $behavior;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @JMS\Expose
     * @JMS\Groups({"api_input"})
     * @Gedmo\Translatable
     */
    private $name;

    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100)
     * @JMS\Expose
     * @JMS\Groups({"api_input"})
     * */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     * @JMS\Expose
     */
    private $description;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;

    /**
     * @var StateEdge[]|Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\Edge\StateEdge",mappedBy="oldState",cascade={"persist"},orphanRemoval=true)
     */
    private $edges;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->edges = new ArrayCollection();
    }

    /**
     * @param Incident $incident
     * @param IncidentState $newState
     * @return Incident
     */
    public function changeIncidentState(Incident $incident, IncidentState $newState = null): ?Incident
    {
        if ($newState) {
            $edge = $this->getNewStateEdge($newState);
            if ($edge) {
                $edge->changeIncidentState($incident);
                $incident->addChangeStateHistory(new IncidentChangeState($incident, $edge));
                return $incident;
            }
        }
        return null;
    }

    /**
     * @param IncidentState $newState
     * @return StateEdge | null
     */
    public function getNewStateEdge(IncidentState $newState): ?StateEdge
    {
        return $this->getEdges()->filter(static function (StateEdge $edge) use ($newState) {
            return $edge->getNewState() === $newState;
        })->first() ?: null;

    }

    /**
     * @return StateEdge[]|Collection
     */
    public function getEdges(): Collection
    {
        return $this->edges;
    }

    /**
     * @param StateEdge $edges
     * @return IncidentState
     */
    public function setEdges(StateEdge $edges): IncidentState
    {
        $this->edges = $edges;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLive(): bool
    {
        return $this->getBehavior()->isLive();
    }

    /**
     * @return StateBehavior
     */
    public function getBehavior(): StateBehavior
    {
        return $this->behavior;
    }

    /**
     * @param StateBehavior $behavior
     * @return IncidentState
     */
    public function setBehavior(StateBehavior $behavior): IncidentState
    {
        $this->behavior = $behavior;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDead(): bool
    {
        return $this->getBehavior()->isDead();
    }

    /**
     * @return bool
     */
    public function isAttended(): bool
    {
        return $this->getBehavior()->isAttended();
    }

    /**
     * @return bool
     */
    public function isResolved(): bool
    {
        return $this->getBehavior()->isResolved();
    }

    /**
     * @return bool
     */
    public function isAddressed(): bool
    {
        return $this->getBehavior()->isAddressed();
    }

    /**
     * @param IncidentState $newState
     * @return bool
     */
    public function canChangeTo(IncidentState $newState): bool
    {
        return $this->getNewStates()->contains($newState);
    }

    /**
     * @return IncidentState[]|ArrayCollection
     */
    public function getNewStates(): ArrayCollection
    {
        return $this->getEdges()->map(static function (StateEdge $edge) {
            return $edge->getNewState();
        });
    }

    /**
     * @param StateEdge $edge
     * @return IncidentState
     */
    public function addEdge(StateEdge $edge): IncidentState
    {
        if ($this->getEdges()->contains($edge)) {
            return null;
        }
        $this->edges[$edge->getNewState()->getId()] = $edge;
        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->getSlug();
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return IncidentState
     */
    public function setSlug(string $slug): IncidentState
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string|null
     */

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function removeEdge(StateEdge $edge): void
    {
        $this->getEdges()->removeElement($edge);
    }

    public function setTranslatableLocale(string $locale): IncidentState
    {
        $this->locale = $locale;
        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return IncidentState
     */
    public function setName(string $name): IncidentState
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return IncidentState
     */
    public function setIsActive(bool $isActive): IncidentState
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     * @return IncidentState
     */
    public function setCreatedAt(DateTime $createdAt): IncidentState
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     * @return IncidentState
     */
    public function setUpdatedAt(DateTime $updatedAt): IncidentState
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
