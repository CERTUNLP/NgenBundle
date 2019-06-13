<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Contact\ContactCase;
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
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class IncidentState implements Translatable
{
    /**
     * @var IncidentStateBehavior
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentStateBehavior", inversedBy="states")
     * @ORM\JoinColumn(name="incident_state_behavior", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $incident_state_behavior;

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
     * @var ContactCase
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_assigned", referencedColumnName="slug")
     */
    private $mailAssigned;

    /**
     * @var ContactCase
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_team", referencedColumnName="slug")
     */

    private $mailTeam;

    /**
     * @var ContactCase
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_admin", referencedColumnName="slug")
     */

    private $mailAdmin;

    /**
     * @var ContactCase
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_reporter", referencedColumnName="slug")
     */

    private $mailReporter;

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
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="state"))
     */
    private $incidents;

    /**
     * @var IncidentStateEdge[]|Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentStateEdge",mappedBy="oldState")
     */
    private $edgesAsOldState;
    /**
     * @var IncidentStateEdge[]|Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentStateEdge",mappedBy="newState")
     */
    private $edgesAsNewState;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->incidents = new ArrayCollection();
        $this->edgesAsNewState = new ArrayCollection();
        $this->edgesAsOldState = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    /**
     * @param mixed $incidents
     * @return IncidentState
     */
    public function setIncidents(Collection $incidents): IncidentState
    {
        $this->incidents = $incidents;
        return $this;
    }

    /**
     * @return IncidentStateEdge[]|Collection
     */
    public function getEdgesAsNewState(): Collection
    {
        return $this->edgesAsNewState;
    }

    /**
     * @param IncidentStateEdge[]|Collection $edgesAsNewState
     * @return IncidentState
     */
    public function setEdgesAsNewState(Collection $edgesAsNewState): IncidentState
    {
        $this->edgesAsNewState = $edgesAsNewState;
        return $this;
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
        return $this->getEdgesAsOldState()->map(static function (IncidentStateEdge $edge) {
            return $edge->getNewState();
        });
    }

    /**
     * @return IncidentStateEdge[]|Collection
     */
    public function getEdgesAsOldState(): Collection
    {
        return $this->edgesAsOldState;
    }

    /**
     * @param IncidentStateEdge[]|Collection $edgesAsOldState
     * @return IncidentState
     */
    public function setEdgesAsOldState(Collection $edgesAsOldState): IncidentState
    {
        $this->edgesAsOldState = $edgesAsOldState;
        return $this;
    }

    public function setTranslatableLocale(string $locale): IncidentState
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOpening(): bool
    {
        return $this->getIncidentStatebehavior()->isCanOpen();
    }

    /**
     * @return IncidentStateBehavior
     */
    public function getIncidentStatebehavior(): IncidentStateBehavior
    {
        return $this->incident_state_behavior;
    }

    /**
     * @param IncidentStateBehavior $incident_state_behavior
     */
    public function setIncidentStatebehavior(IncidentStateBehavior $incident_state_behavior): void
    {
        $this->incident_state_behavior = $incident_state_behavior;
    }

    /**
     * @return bool
     */
    public function isClosing(): bool
    {
        return $this->getIncidentStatebehavior()->isCanClose();
    }

    /**
     * @return bool
     */
    public function isReOpening(): bool
    {
        return $this->getIncidentStatebehavior()->isCanReOpen();
    }

    /**
     * @return ContactCase
     */
    public function getMailAssigned(): ?ContactCase
    {
        return $this->mailAssigned;
    }

    /**
     * @param ContactCase $mailAssigned
     * @return IncidentState
     */
    public function setMailAssigned(ContactCase $mailAssigned): IncidentState
    {
        $this->mailAssigned = $mailAssigned;
        return $this;
    }

    /**
     * @return ContactCase
     */
    public function getMailTeam(): ?ContactCase
    {
        return $this->mailTeam;
    }

    /**
     * @param ContactCase $mailTeam
     * @return IncidentState
     */
    public function setMailTeam(ContactCase $mailTeam): IncidentState
    {
        $this->mailTeam = $mailTeam;
        return $this;
    }

    /**
     * @return ContactCase
     */
    public function getMailAdmin(): ?ContactCase
    {
        return $this->mailAdmin;
    }

    /**
     * @param ContactCase $mailAdmin
     * @return IncidentState
     */
    public function setMailAdmin(ContactCase $mailAdmin): IncidentState
    {
        $this->mailAdmin = $mailAdmin;
        return $this;

    }

    /**
     * @return ContactCase
     */
    public function getMailReporter(): ?ContactCase
    {
        return $this->mailReporter;
    }

    /**
     * @param ContactCase $mailReporter
     * @return IncidentState
     */
    public function setMailReporter(ContactCase $mailReporter): IncidentState
    {
        $this->mailReporter = $mailReporter;
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

    /**
     * Add incident
     *
     * @param Incident $incident
     *
     * @return IncidentState
     */
    public function addIncident(Incident $incident): IncidentState
    {
        $this->incidents[] = $incident;

        return $this;
    }

    /**
     * Remove incident
     *
     * @param Incident $incident
     * @return bool
     */
    public function removeIncident(Incident $incident): bool
    {
        return $this->incidents->removeElement($incident);
    }
}
