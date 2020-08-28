<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network;
use CertUnlp\NgenBundle\Entity\EntityApiFrontend;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Incident\IncidentDecisionRepository")
 * @ORM\EntityListeners({"CertUnlp\NgenBundle\Service\Listener\Entity\IncidentDecisionListener"})
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"type","feed","network"},
 *     errorPath="type",
 *     ignoreNull=false,
 *     message="This decision already in exists."
 * )
 */
class IncidentDecision extends EntityApiFrontend
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var IncidentType|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $type;
    /**
     * @var IncidentFeed|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentFeed")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $feed;
    /**
     * @var Network|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network")
     * @ORM\JoinColumn(name="network", referencedColumnName="id")
     * @JMS\Expose()
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $network;
    /**
     * @var IncidentPriority|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentPriority")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $priority;
    /**
     * @var IncidentImpact|null
     */
    private $impact;
    /**
     * @var IncidentUrgency|null
     */
    private $urgency;
    /**
     * @var IncidentTlp|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentTlp")
     * @ORM\JoinColumn(name="tlp", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $tlp;
    /**
     * @var IncidentState|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $state;
    /**
     * @var IncidentState|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="unattended_state", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $unattendedState;
    /**
     * @var IncidentState|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="unsolved_state", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $unsolvedState;
    /**
     * @var boolean
     *
     * @ORM\Column(name="auto_saved", type="boolean")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $autoSaved = false;

    /**
     * @return IncidentPriority|null
     */
    public function getPriority(): ?IncidentPriority
    {
        return $this->priority;
    }

    /**
     * @param IncidentPriority|null $priority
     * @return IncidentDecision
     */
    public function setPriority(?IncidentPriority $priority): IncidentDecision
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return bool
     */
    public function canEditFundamentals(): bool
    {
        return !$this->isUndefined() && $this->getNetwork() !== null;
    }

    /**
     * @return bool
     */
    public function isUndefined(): bool
    {
        return $this->getType()->isUndefined() && $this->getFeed()->isUndefined();
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
     * {@inheritDoc}
     */
    public function getDataIdentificationArray(): array
    {
        return ['type' => $this->getType() ? $this->getType()->getSlug() : 'undefined', 'feed' => $this->getFeed() ? $this->getFeed()->getSlug() : 'undefined', 'network' => $this->getNetwork() ? $this->getNetwork()->getId() : null];
    }

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
        return $this->getType()->getSlug() . '_' . $this->getFeed()->getSlug();
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
        $incident->getState() ?: $incident->setState($this->getState());
        $incident->getType() ?: $incident->setType($this->getType());

        if ($incident->getState() && $incident->getState()->isInitial()) {
            $incident->setState($this->getState());
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return string
     */
    public function getIdentificationString(): string
    {
        return 'id';
    }
}

