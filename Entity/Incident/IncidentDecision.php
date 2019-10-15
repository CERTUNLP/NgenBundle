<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\Network\Network;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * IncidentDecision
 *
 * @ORM\Table(name="incident_decision")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IncidentDecisionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class IncidentDecision extends Entity
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose()
     */
    protected $id;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose()
     */
    protected $createdAt;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose()
     */
    protected $updatedAt;
    /**
     * @var IncidentType|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $type;
    /**
     * @var IncidentFeed|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentFeed")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $feed;
    /**
     * @var Network|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\Network")
     * @ORM\JoinColumn(name="network", referencedColumnName="id")
     * @JMS\Expose()
     */
    protected $network;
    /**
     * @var IncidentImpact|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentImpact")
     * @ORM\JoinColumn(name="impact", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $impact;
    /**
     * @var IncidentUrgency|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency")
     * @ORM\JoinColumn(name="urgency", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $urgency;
    /**
     * @var IncidentTlp|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentTlp")
     * @ORM\JoinColumn(name="tlp", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $tlp;
    /**
     * @var IncidentState|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $state;
    /**
     * @var IncidentState|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="unattended_state", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $unattendedState;
    /**
     * @var IncidentState|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="unsolved_state", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $unsolvedState;
    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=100)
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\RelativeSlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="relationField", value="type"),
     *          @Gedmo\SlugHandlerOption(name="relationSlugField", value="slug"),
     *          @Gedmo\SlugHandlerOption(name="separator", value="_")
     *      })
     * }, fields={"id"})
     *
     */
    protected $slug;
    /**
     * @var boolean
     *
     * @ORM\Column(name="auto_saved", type="boolean")
     * @JMS\Expose()
     */
    private $autoSaved = false;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose()
     */
    private $isActive = true;

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'question-circle';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'info';
    }

    public function __toString(): string
    {
        return $this->getSlug();
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return IncidentDecision
     */
    public function setSlug(string $slug): IncidentDecision
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return IncidentFeed|null
     */
    public function getFeed(): ?IncidentFeed
    {
        return $this->feed;
    }

    /**
     * @param IncidentFeed|null $feed
     * @return IncidentDecision
     */
    public function setFeed(?IncidentFeed $feed): IncidentDecision
    {
        $this->feed = $feed;
        return $this;
    }

    /**
     * @param Incident $incident
     * @return Incident
     */
    public function doDecision(Incident $incident): Incident
    {
        $incident->getTlp() ?: $incident->setTlp($this->getTlp());
        $incident->getImpact() ?: $incident->setImpact($this->getImpact());
        $incident->getUrgency() ?: $incident->setUrgency($this->getUrgency());
        $incident->getState() ?: $incident->setStateAndReporter($this->getState(), $incident->getReporter());
        $incident->getType() ?: $incident->setType($this->getType());

        if ($incident->getState()) {
            if ($incident->getState()->isInitial()) {
                $incident->setStateAndReporter($this->getState(), $incident->getReporter());
            }
        } else {
            $incident->setStateAndReporter($this->getState(), $incident->getReporter());
        }
        return $incident;
    }

    /**
     * @return IncidentTlp|null
     */
    public function getTlp(): ?IncidentTlp
    {
        return $this->tlp;
    }

    /**
     * @param IncidentTlp|null $tlp
     * @return IncidentDecision
     */
    public function setTlp(?IncidentTlp $tlp): IncidentDecision
    {
        $this->tlp = $tlp;
        return $this;
    }

    /**
     * @return IncidentImpact|null
     */
    public function getImpact(): ?IncidentImpact
    {
        return $this->impact;
    }

    /**
     * @param IncidentImpact|null $impact
     * @return IncidentDecision
     */
    public function setImpact(?IncidentImpact $impact): IncidentDecision
    {
        $this->impact = $impact;
        return $this;
    }

    /**
     * @return IncidentUrgency|null
     */
    public function getUrgency(): ?IncidentUrgency
    {
        return $this->urgency;
    }

    /**
     * @param IncidentUrgency|null $urgency
     * @return IncidentDecision
     */
    public function setUrgency(?IncidentUrgency $urgency): IncidentDecision
    {
        $this->urgency = $urgency;
        return $this;
    }

    /**
     * @return IncidentState|null
     */
    public function getState(): ?IncidentState
    {
        return $this->state;
    }

    /**
     * @param IncidentState|null $state
     * @return IncidentDecision
     */
    public function setState(?IncidentState $state): IncidentDecision
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return IncidentType|null
     */
    public function getType(): ?IncidentType
    {
        return $this->type;
    }

    /**
     * @param IncidentType|null $type
     * @return IncidentDecision
     */
    public function setType(?IncidentType $type): IncidentDecision
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return IncidentDecision
     */
    public function setId(?int $id): IncidentDecision
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return IncidentDecision
     */
    public function setCreatedAt(DateTime $createdAt): IncidentDecision
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return IncidentDecision
     */
    public function setUpdatedAt(DateTime $updatedAt): IncidentDecision
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Network|null
     */
    public function getNetwork(): ?Network
    {
        return $this->network;
    }

    /**
     * @param Network|null $network
     * @return IncidentDecision
     */
    public function setNetwork(?Network $network): IncidentDecision
    {
        $this->network = $network;
        return $this;
    }

    /**
     * @return IncidentState|null
     */
    public function getUnattendedState(): ?IncidentState
    {
        return $this->unattendedState;
    }

    /**
     * @param IncidentState|null $unattendedState
     * @return IncidentDecision
     */
    public function setUnattendedState(?IncidentState $unattendedState): IncidentDecision
    {
        $this->unattendedState = $unattendedState;
        return $this;
    }

    /**
     * @return IncidentState|null
     */
    public function getUnsolvedState(): ?IncidentState
    {
        return $this->unsolvedState;
    }

    /**
     * @param IncidentState|null $unsolvedState
     * @return IncidentDecision
     */
    public function setUnsolvedState(?IncidentState $unsolvedState): IncidentDecision
    {
        $this->unsolvedState = $unsolvedState;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoSaved(): bool
    {
        return $this->autoSaved;
    }

    /**
     * @param bool $autoSaved
     * @return IncidentDecision
     */
    public function setAutoSaved(bool $autoSaved): IncidentDecision
    {
        $this->autoSaved = $autoSaved;
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
     * @return IncidentDecision
     */
    public function setIsActive(bool $isActive): IncidentDecision
    {
        $this->isActive = $isActive;
        return $this;
    }


}

