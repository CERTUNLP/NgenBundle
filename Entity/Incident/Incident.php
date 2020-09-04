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

use CertUnlp\NgenBundle\Entity\Communication\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Host;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network;
use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\EntityApiFrontend;
use CertUnlp\NgenBundle\Entity\Incident\State\Behavior\StateBehavior;
use CertUnlp\NgenBundle\Entity\Incident\State\Edge\StateEdge;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User\User;
use CertUnlp\NgenBundle\Model\EntityInterface;
use CertUnlp\NgenBundle\Validator\Constraints as CustomAssert;
use DateInterval;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use FOS\CommentBundle\Model\Thread;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Incident\IncidentRepository")
 * @ORM\EntityListeners({"CertUnlp\NgenBundle\Service\Listener\Entity\IncidentListener"})
 * @ORM\HasLifecycleCallbacks
 * @JMS\ExclusionPolicy("all")
 */
class Incident extends EntityApiFrontend
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     * @JMS\Groups({"read"})
     */
    protected $id;
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"id"},separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read"})
     * */
    protected $slug;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="response_dead_line", type="datetime",nullable=true))
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"read","write"})
     */
    private $responseDeadLine;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="solve_dead_line", type="datetime",nullable=true))
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"read","write"})
     */
    private $solveDeadLine;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User\User", inversedBy="incidents")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $reporter;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User\User", inversedBy="assignedIncidents")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $assigned;
    /**
     * @var IncidentType
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType",inversedBy="incidents")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"read","write","fundamental"})
     * @JMS\MaxDepth(depth=1)
     */
    private $type;
    /**
     * @var IncidentFeed
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentFeed", inversedBy="incidents")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @Assert\NotNull
     * @JMS\Expose
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $feed;
    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState", inversedBy="incidents")
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     * @JMS\MaxDepth(depth=1)
     */
    private $state;
    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="unattended_state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     * @JMS\MaxDepth(depth=1)
     */
    private $unattendedState;
    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="unsolved_state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     * @JMS\MaxDepth(depth=1)
     */
    private $unsolvedState;
    /**
     * @var IncidentTlp
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentTlp", inversedBy="incidents")
     * @ORM\JoinColumn(name="tlp_state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $tlp;
    /**
     * @var IncidentPriority
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentPriority", inversedBy="incidents")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     * @JMS\MaxDepth(depth=1)
     */
    private $priority;
    /**
     * @var IncidentImpact
     */
    private $impact = null;
    /**
     * @var IncidentUrgency
     */
    private $urgency = null;
    /**
     * @var IncidentCommentThread
     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentCommentThread",mappedBy="incident",fetch="EXTRA_LAZY"))
     */
    private $comment_thread;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"read","write"})
     */
    private $date;
    /**
     * @var Collection
     * @JMS\Expose
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentDetected",mappedBy="incident",cascade={"persist"},orphanRemoval=true)
     * @JMS\Groups({"read","write"})
     * @JMS\MaxDepth(depth=2)
     */
    private $incidentsDetected;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentStateChange",mappedBy="incident",cascade={"persist"},orphanRemoval=true)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     * @JMS\MaxDepth(depth=2)
     */
    private $state_changes;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Communication\Message\Message",mappedBy="incident")
     * @JMS\Expose
     * @JMS\Groups({"read"})
     */
    private $messages;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="renotification_date", type="datetime",nullable=true)
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $renotificationDate;
    /**
     * @var Host|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Host", inversedBy="incidents")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $origin;

//    /**
//     * @var Collection
//     * @JMS\Expose
//     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Communication\Message",mappedBy="incident",cascade={"persist"},orphanRemoval=true)
//     * @JMS\Groups({"api"})
//     */
//
//    private $communicationHistory;
    /**
     * @var Network|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network", inversedBy="incidents")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $network;
    /**
     * @var boolean
     */
    private $needToCommunicate = false;
    /**
     * @Assert\File(maxSize = "5M")
     */
    private $evidence_file;
    /**
     * @ORM\Column(name="evidence_file_path", type="string",nullable=true)
     */
    private $evidence_file_path;
    /**
     * @var string
     * @ORM\Column(name="report_message_id", type="string",nullable=true)
     */
    private $report_message_id;
    /**
     * @var bool
     */
    private $notSendReport = false;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;
    /**
     * @ORM\Column(name="ltd_count", type="integer")
     */
    private $ltdCount = 0;
    /**
     * @CustomAssert\ValidAddress()
     * @JMS\Expose
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $address;
    /**
     * @var User
     */
    private $responsable;

    /**
     * Incident constructor.
     * @param string|null $term
     */
    public function __construct(string $term = null)
    {
        if ($term) {
            $this->setAddress($term);
        }
        $this->incidentsDetected = new ArrayCollection();
        $this->state_changes = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    /**
     * @param Collection $messages
     * @return Incident
     */
    public function setMessages(Collection $messages): Incident
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * @return User
     */
    public function getResponsable(): ?User
    {
        return $this->responsable;
    }

    /**
     * @param User|null $responsable
     * @return Incident
     */
    public function setResponsable(?User $responsable): Incident
    {
        $this->responsable = $responsable;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'exclamation-circle';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->getState()->getColor();
    }

    /**
     * Get $state
     *
     * @return IncidentState
     */
    public function getState(): ?IncidentState
    {
        return $this->state;
    }

    /**
     * Set state
     * @param IncidentState $state
     * @return Incident
     */
    public function setState(IncidentState $state = null): ?Incident
    {
        if ($this->getState()) {
            return $this->getState()->changeState($this, $state);
        }
        return $this->changeState($state);
    }

    /**
     * Set state
     * @param IncidentState $state
     * @return Incident
     */
    public function changeState(IncidentState $state = null): Incident
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getResponseDeadLine(): ?DateTime
    {
        return $this->responseDeadLine;
    }

    /**
     * @param DateTime $responseDeadLine
     * @return Incident
     */
    public function setResponseDeadLine(DateTime $responseDeadLine = null): self
    {
        $this->setter($this->responseDeadLine, $responseDeadLine);
        return $this;
    }

    /**
     * @param mixed $property
     * @param mixed $value
     * @param bool $fundamental
     * @return bool
     */
    public function setter(&$property, $value, bool $fundamental = false): bool
    {
        if ($this->getBehavior()) {
            return $this->getBehavior()->setter($property, $value, $fundamental);
        }
        $property = $value;
        return true;
    }

    /**
     * @return StateBehavior
     */
    public function getBehavior(): ?StateBehavior
    {
        return $this->getState() ? $this->getState()->getBehavior() : null;
    }

    /**
     * @return DateTime
     */
    public function getSolveDeadLine(): ?DateTime
    {
        return $this->solveDeadLine;
    }

    /**
     * @param DateTime $solveDeadLine
     * @return Incident
     */
    public function setSolveDeadLine(DateTime $solveDeadLine = null): self
    {
        $this->setter($this->solveDeadLine, $solveDeadLine);

        return $this;
    }

    /**
     * @return IncidentState
     */
    public function getUnattendedState(): ?IncidentState
    {
        return $this->unattendedState;
    }

    /**
     * @param IncidentState $unattendedState
     * @return Incident
     */
    public function setUnattendedState(IncidentState $unattendedState = null): self
    {
        $this->setter($this->unattendedState, $unattendedState);
        return $this;
    }

    /**
     * @return IncidentState
     */
    public function getUnsolvedState(): ?IncidentState
    {
        return $this->unsolvedState;
    }

    /**
     * @param IncidentState $unsolvedState
     * @return Incident
     */
    public function setUnsolvedState(IncidentState $unsolvedState = null): self
    {
        $this->setter($this->unsolvedState, $unsolvedState);
        return $this;
    }

    /**
     * @return bool
     */
    public function canEdit(): bool
    {
        return $this->getBehavior() ? $this->getBehavior()->canEdit() : false;
    }

    /**
     * @return bool
     */
    public function canEditFundamentals(): bool
    {
        return $this->getBehavior() ? $this->getBehavior()->canEditFundamentals() : false;
    }

    /**
     * @param IncidentStateChange $changeState
     * @return Incident
     */
    public function addStateChange(IncidentStateChange $changeState): Incident
    {
        return $this->getBehavior()->addStateChange($this, $changeState);
    }

    /**
     * @return int
     */
    public function getLtdCount(): int
    {
        return $this->ltdCount;
    }

    /**
     * @return bool
     */
    public function canCommunicateComment(): bool
    {
        return $this->isLive();
    }

    public function isLive(): bool
    {
        return $this->getState()->isLive();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Entity|Incident
     */
    public function setId($id): Entity
    {
        $identificator_string = $this->getIdentificationString();
        $this->setter($this->$identificator_string, $id);
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentificationString(): string
    {
        return 'id';
    }

    /**
     * @return DateTime
     */
    public function getRenotificationDate(): DateTime
    {
        return $this->renotificationDate;
    }

    /**
     * @param DateTime $renotificationDate
     * @return Incident
     */
    public function setRenotificationDate(DateTime $renotificationDate): Incident
    {
        $this->setter($this->renotificationDate, $renotificationDate);
        return $this;
    }

    /**
     * @return IncidentFeed
     */
    public function getFeed(): ?IncidentFeed
    {
        return $this->feed;
    }

    /**
     * @param IncidentFeed $feed
     * @return Incident
     */
    public function setFeed(IncidentFeed $feed): Incident
    {
        $this->setter($this->feed, $feed, true);
        return $this;
    }

    /**
     * @return IncidentUrgency
     */
    public function getUrgency(): ?IncidentUrgency
    {
        return $this->urgency;
    }

    /**
     * @param IncidentUrgency|null $urgency
     * @return Incident
     */
    public function setUrgency(?IncidentUrgency $urgency): Incident
    {
        $this->setter($this->urgency, $urgency);
        return $this;
    }

    /**
     * @return IncidentImpact
     */
    public function getImpact(): ?IncidentImpact
    {
        return $this->impact;
    }

    /**
     * @param IncidentImpact $impact
     * @return Incident
     */
    public function setImpact(?IncidentImpact $impact): Incident
    {
        $this->setter($this->impact, $impact);
        return $this;
    }

    /**
     * @return string
     */
    public function getReportMessageId(): ?string
    {
        return $this->report_message_id;
    }

    /**
     * @param string $report_message_id
     * @return Incident
     */
    public function setReportMessageId(string $report_message_id): Incident
    {
        $this->setter($this->report_message_id, $report_message_id);
        return $this;
    }

    /**
     * @return IncidentCommentThread
     */
    public function getCommentThread(): ?IncidentCommentThread
    {
        return $this->comment_thread;
    }

    /**
     * @param Thread $comment_thread
     * @return Incident
     */
    public function setCommentThread(Thread $comment_thread): Incident
    {
        $this->setter($this->comment_thread, $comment_thread);
        return $this;
    }

    /**
     * @return string
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     * @return Incident
     */
    public function setNotes(string $notes): Incident
    {
        $this->setter($this->notes, $notes);
        return $this;
    }

    public function __toString(): string
    {
        return $this->getSlug();
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug ?: 'ss';
    }

    /**
     * @param string $slug
     * @return Incident
     */
    public function setSlug(?string $slug): Incident
    {
        $this->setter($this->slug, $slug);
        return $this;
    }

    /**
     * @param DateTime $updatedAt
     * @return Entity
     */
    public function setUpdatedAt(DateTime $updatedAt): Entity
    {
        $this->setter($this->updatedAt, $updatedAt);
        return $this;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getNewMinutes(): int
    {
        return $this->getBehavior()->getNewMinutes($this);
    }

    /**
     * @param ArrayCollection $incidentDetectedCollection
     */

    public function setIncidentesDetected(ArrayCollection $incidentDetectedCollection): void
    {
        $this->setter($this->incidentsDetected, $incidentDetectedCollection);
    }

    /**
     * @param Incident $incidentDetected
     * @return Incident
     */
    public function addIncidentDetected(Incident $incidentDetected): Incident
    {
        return $this->getBehavior()->addIncidentDetected($this, $incidentDetected);
    }

    /**
     * @return bool
     */
    public function canEnrich(): bool
    {
        return $this->getBehavior()->canEnrich();
    }

    public function increaseLtdCount(): void
    {
        ++$this->ltdCount;
    }

    /**
     * @return array
     */
    public function getContactsArray(): array
    {
        return $this->getContacts()->toArray();
    }

    /**
     * @return ArrayCollection
     */
    public function getContacts(): ArrayCollection
    {
        $contactos = [];

        $contactos = array_merge($contactos, $this->getAssignedContacts()->toArray());

        $contactos = array_merge($contactos, $this->getReporterContacts()->toArray());

        $contactos = array_merge($contactos, $this->getNetworkAdminContacts()->toArray());

        return new ArrayCollection($contactos);
    }

    /**
     * @return ArrayCollection
     */
    public function getAssignedContacts(): ArrayCollection
    {
        if ($this->getAssigned() && $this->getStateEdge()->getMailAssigned()->getLevel() >= $this->getPriority()->getCode()) {
            return $this->getAssigned()->getContacts($this->getPriority()->getCode());
        }
        return new ArrayCollection();
    }

    /**
     * @return User
     */
    public function getAssigned(): ?User
    {
        return $this->assigned;
    }

    /**
     * @param User $assigned
     * @return Incident
     */
    public function setAssigned(User $assigned): Incident
    {
        $this->setter($this->assigned, $assigned);
        return $this;
    }

    /**
     * @return StateEdge
     */
    public function getStateEdge(): ?StateEdge
    {
        if ($this->getStatechanges()) {
            return $this->getStatechanges()->last() ? $this->getStatechanges()->last()->getStateEdge() : null;

        }
        return null;
    }

    /**
     * @return Collection
     */
    public function getStatechanges(): Collection
    {
        return $this->state_changes;
    }

    /**
     * @param ArrayCollection $state_changes
     */
    public function setStatechanges(ArrayCollection $state_changes): void
    {
        $this->setter($this->state_changes, $state_changes);
    }

    /**
     * @return IncidentPriority
     */
    public function getPriority(): ?IncidentPriority
    {
        return $this->priority;
    }

    /**
     * @param IncidentPriority $priority
     * @return Incident
     */
    public function setPriority(IncidentPriority $priority): Incident
    {
        $this->setter($this->priority, $priority);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getReporterContacts(): ArrayCollection
    {
        if ($this->getReporter() && $this->getStateEdge()->getMailReporter()->getLevel() >= $this->getPriority()->getCode()) {
            return $this->getReporter()->getContacts($this->getPriority()->getCode());
        }
        return new ArrayCollection();
    }

    /**
     * @return User
     */
    public function getReporter(): ?User
    {
        return $this->reporter;
    }

    /**
     * @param User $reporter
     * @return Incident
     */
    public function setReporter(User $reporter = null): Incident
    {
        $this->setter($this->reporter, $reporter);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getNetworkAdminContacts(): ArrayCollection
    {
        if ($this->getNetworkAdmin() && $this->getStateEdge()->getMailAdmin()->getLevel() >= $this->getPriority()->getCode()) {
            return $this->getNetworkAdmin()->getContacts($this->getPriority()->getCode());
        }
        return new ArrayCollection();
    }

    public function getNetworkAdmin(): ?NetworkAdmin
    {
        if ($this->getNetwork()) {
            return $this->getNetwork()->getNetworkAdmin();
        }
        return null;
    }

    /**
     * @return Network
     */
    public function getNetwork(): ?Network
    {
        return $this->network;
    }

    /**
     * @param Network $network
     * @return Incident
     */
    public function setNetwork(Network $network = null): Incident
    {
        $this->setter($this->network, $network);
        return $this;
    }

    /**
     * @return DateInterval|false
     * @throws Exception
     * @example if int positive incident is on time, if int is negative incident is delayed
     */
    public function getResponseDelayedDate()
    {
        $fecha = new DateTime();
        $minutes = $this->getResponseDelayedMinutes();
        $intervalo = 'PT' . ($minutes >= 0 ? $minutes : $minutes * -1) . 'M';
        $date_interval = new DateInterval($intervalo);
        $fecha->sub($date_interval);

        return $fecha->diff(new DateTime());
    }

    /**
     * @return int
     * @throws Exception
     * @example if int positive incident is on time, if int is negative incident is delayed
     */
    public function getResponseDelayedMinutes(): int
    {
        return $this->getPriority()->getResponseTime() - $this->getResponseMinutes();

    }

    /**
     * @return int
     * @throws Exception
     */
    public function getResponseMinutes(): int
    {
        return $this->getResponseTime() / 60;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getResponseTime(): int
    {
        if ($this->getResponsedDate()) {
            return abs($this->getCreatedAt()->getTimestamp() - $this->getResponsedDate()->getTimestamp());
        }
        return abs($this->getCreatedAt()->getTimestamp() - (new DateTime())->getTimestamp());
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getResponsedDate(): ?DateTime
    {
        if (!$this->getAttendedChangeStates()->isEmpty()) {
            return $this->getAttendedChangeStates()->last()->getDate();
        }
        return null;
    }

    /**
     * @return IncidentStateChange[] | Collection
     */
    public function getAttendedChangeStates(): Collection
    {
        if ($this->getStatechanges()) {
            return $this->getStatechanges()->filter(static function (IncidentStateChange $changeState) {
                return $changeState->getNewState()->isAttended();
            });
        }
        return new ArrayCollection();
    }

    /**
     * @param DateTime $createdAt
     * @return Entity
     */
    public function setCreatedAt(DateTime $createdAt): Entity
    {
        $this->setter($this->createdAt, $createdAt);
        return $this;
    }

    /**
     * @return DateInterval|false
     * @throws Exception
     * @example if int positive incident is on time, if int is negative incident is delayed
     */
    public function getResolutionDelayedDate()
    {
        $fecha = new DateTime();
        $minutes = $this->getResolutionDelayedMinutes();

        $intervalo = 'PT' . ($minutes >= 0 ? $minutes : $minutes * -1) . 'M';
        $date_interval = new DateInterval($intervalo);
        $fecha->sub($date_interval);

        return $fecha->diff(new DateTime());
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getResolutionDelayedMinutes(): int
    {
        return $this->getPriority()->getResolutionTime() - $this->getResolutionMinutes();
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getResolutionMinutes(): int
    {
        return $this->getResolutionTime() / 60;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getResolutionTime(): int
    {
        if ($this->getResolutionDate()) {
            return abs($this->getCreatedAt()->getTimestamp() - $this->getResolutionDate()->getTimestamp());
        }
        return abs($this->getCreatedAt()->getTimestamp() - (new DateTime())->getTimestamp());
    }

    /**
     * @return DateTime|null
     */
    public function getResolutionDate(): ?DateTime
    {
        if (!$this->getResolvedChangeStates()->isEmpty()) {
            return $this->getResolvedChangeStates()->last()->getDate();
        }
        return null;
    }

    /**
     *
     * @return IncidentStateChange[] | Collection
     */
    public function getResolvedChangeStates(): Collection
    {
        if ($this->getStatechanges()) {
            return $this->getStatechanges()->filter(static function (IncidentStateChange $changeState) {
                return $changeState->getNewState()->isResolved();
            });
        }
        return new ArrayCollection();
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getResolutionPercentage(): int
    {
        $minutes = ($this->getResolutionMinutes() * 100) / $this->getPriority()->getResolutionTime();

        return $minutes < 100 ? $minutes : 100;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getResponsePercentage(): int
    {
        $minutes = ($this->getResponseMinutes() * 100) / $this->getPriority()->getResponseTime();

        return $minutes < 100 ? $minutes : 100;
    }

    public function isDead(): bool
    {
        return $this->getState()->isDead();
    }

    public function isAttended(): bool
    {
        return $this->getState()->isAttended();
    }

    public function isResolved(): bool
    {
        return $this->getState()->isResolved();
    }

    public function statusToString(): string
    {
        return $this->getBehavior()->getName();
    }

    /**
     * @return array
     */
    public function getEmails(): array
    {
        return array_filter($this->getEmailContacts()->map(static function (Contact $contact) {
            return $contact->getEmail();
        })->toArray(), static function ($value) {
            return $value !== '';
        });
    }

    /**
     * @return ArrayCollection
     */
    public function getEmailContacts(): ArrayCollection
    {
        return $this->getContacts()->filter(static function (Contact $contact) {
            return $contact->getEmail();
        });
    }

    /**
     * @return array
     */
    public function getStateRatio(): array
    {
        return $this->getRatio($this->getIncidentsDetected(), static function (IncidentDetected $detected) {
            return $detected->getState()->getName();
        });
    }

    /**
     * @return Collection| IncidentDetected[]
     */
    public function getIncidentsDetected(): ?Collection
    {
        return $this->incidentsDetected;
    }

    /**
     * @return array
     */
    public function getDateRatio(): array
    {
        return $this->getRatio($this->getIncidentsDetected(), static function (IncidentDetected $detected) {
            return $detected->getDate()->format('d-m');
        });
    }

    /**
     * @return array
     */
    public function getStateTimelineRatio(): array
    {
        $states = [];
        $suffix = '';

        $states_changes = $this->getStatechanges()->filter(static function (IncidentStateChange $changeState) {
            return $changeState->getOldState()->getSlug() !== $changeState->getNewState()->getSlug();
        });
        if (!$states_changes->contains($this->getStatechanges()->first())) {
            $states_changes->set(0, $this->getStatechanges()->first());
        }
        if (!$states_changes->contains($this->getStatechanges()->last())) {
            $states_changes->add($this->getStatechanges()->last());
        }

        foreach ($states_changes as $detected) {
            if (isset($states[$detected->getOldState()->getName() . '-' . $suffix])) {
                $states[$detected->getOldState()->getName() . '-' . $suffix][3] = $detected->getDate();
            } elseif (isset($states[$detected->getOldState()->getName()])) {
                $states[$detected->getOldState()->getName()][3] = $detected->getDate();
            } else {
                $states[$detected->getOldState()->getName()] = ['state', $detected->getOldState()->getName(), $detected->getDate(), $detected->getDate()];
            }

            if (isset($states[$detected->getNewState()->getName()]) && $detected->getNewState()->getName() !== $detected->getOldState()->getName()) {
                $suffix++;
                $states[$detected->getNewState()->getName() . '-' . $suffix] = ['state', $detected->getNewState()->getName() . '-' . $suffix, $detected->getDate(), $detected->getDate()];
            } elseif ($detected->getNewState()->getName() === $detected->getOldState()->getName()) {
                $states[$detected->getOldState()->getName()][3] = $detected->getDate();
            } else {
                $states[$detected->getNewState()->getName()] = ['state', $detected->getNewState()->getName(), $detected->getDate(), $detected->getDate()];
            }
        }
        return $states;
    }

    /**
     * @return array
     */
    public function getFeedRatio(): array
    {
        return $this->getRatio($this->getIncidentsDetected(), static function (IncidentDetected $detected) {
            return $detected->getFeed()->getName();
        });
    }

    /**
     * @return array
     */
    public function getTlpRatio(): array
    {
        return $this->getRatio($this->getIncidentsDetected(), static function (IncidentDetected $detected) {
            return $detected->getTlp()->getName();
        });
    }

    /**
     * @return array
     */
    public function getPriorityRatio(): array
    {
        return $this->getRatio($this->getIncidentsDetected(), static function (IncidentDetected $detected) {
            return $detected->getPriority()->getName();
        });
    }

    /**
     * @return bool
     */
    public function canCommunicate(): bool
    {
        return !$this->isNotSendReport() && $this->getBehavior()->canComunicate() && $this->isNeedToCommunicate() && !$this->getType()->isUndefined();
    }

    /**
     * @return bool
     */
    public function isNotSendReport(): bool
    {
        return $this->notSendReport;
    }

    /**
     * @param bool $notSendReport
     * @return Incident
     */
    public function setNotSendReport(bool $notSendReport): Incident
    {
        $this->notSendReport = $notSendReport;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNeedToCommunicate(): bool
    {
        return $this->needToCommunicate;
    }

    /**
     * @param bool $needToCommunicate
     * @return Incident
     */
    public function setNeedToCommunicate(bool $needToCommunicate): Incident
    {
        $this->setter($this->needToCommunicate, $needToCommunicate);
        return $this;
    }

    /**
     */
    public function getType(): ?IncidentType
    {
        return $this->type;
    }

    /**
     * @param IncidentType|null $type
     * @return Incident
     */
    public function setType(IncidentType $type = null): Incident
    {
        $this->setter($this->type, $type, true);
        return $this;
    }

    /**
     * @return array
     */
    public function getTelegrams(): array
    {
        return array_filter($this->getTelegramContacts()->map(static function (Contact $contact) {
            return $contact->getTelegram();
        })->toArray(), static function ($value) {
            return $value !== '';
        });
    }

    /**
     * @return ArrayCollection
     */
    public function getTelegramContacts(): ArrayCollection
    {
        return $this->getContacts()->filter(static function (Contact $contact) {
            return $contact->getTelegram();
        });
    }

    /**
     * Get evidence_file
     *
     * @return UploadedFile
     */
    public function getEvidenceFile(): ?UploadedFile
    {
        return $this->evidence_file;
    }

    /**
     * Set evidence_file
     *
     * @param File|null $evidenceFile
     * @return Incident
     */
    public function setEvidenceFile(File $evidenceFile = null): Incident
    {
        $this->setter($this->evidence_file, $evidenceFile);
//        $this->setEvidenceFilePath($evidenceFile->getFilename());
        return $this;
    }

    /**
     * Get evidence_file_path
     *
     * @param string|null $fullPath
     * @return string
     */
    public function getEvidenceFilePath(string $fullPath = null): string
    {

        if ($this->evidence_file_path) {

            if ($fullPath) {
                $pre_path = $this->getEvidenceSubDirectory() . '/';
            } else {
                $pre_path = '';
            }

            return $pre_path . $this->evidence_file_path;
        }
        return '';
    }

    /**
     * @param mixed $evidence_file_path
     * @return Incident
     */
    public function setEvidenceFilePath(string $evidence_file_path = null): Incident
    {
        $this->setter($this->evidence_file_path, $evidence_file_path);
        return $this;
    }

    /**
     * Get evidence_file_path
     *
     * @return string
     */
    public function getEvidenceSubDirectory(): ?string
    {
        return '/' . $this->getSlug() . '/' . sha1($this->getDate()->format('Y-m-d-h-i'));
    }

    /**
     * @return DateTime
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime|null $date
     * @return Incident
     */
    public function setDate(DateTime $date = null): Incident
    {
        $this->setter($this->date, $date);
        return $this;
    }

    /**
     * @return Host
     */
    public function getDestination(): ?Host
    {
        return $this->destination;
    }

    /**
     * @param Host $destination
     * @return Incident
     */
    public function setDestination(Host $destination): Incident
    {
        $this->setter($this->destination, $destination);
        return $this;
    }

    /**
     * @return Host
     */
    public function getHostAddress(): ?string
    {
        return $this->getAddress();
    }

    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->getOrigin() ? $this->getOrigin()->getAddress() : $this->address;
    }

    /**
     * Set ip
     *
     * @param string $address
     * @return Incident
     */
    public function setAddress(string $address): Incident
    {
        if ($this->getOrigin() && $this->getOrigin()->getAddress() !== $address) {
            $old_origin = $this->getOrigin();
            $this->setOrigin();
            if (!$this->setter($this->address, $address, true)) {
                $this->setOrigin($old_origin);
            }

        } else {
            $this->setter($this->address, $address, true);
        }
        return $this;
    }

    /**
     * @return Host
     */
    public function getOrigin(): ?Host
    {
        return $this->origin;
    }

    /**
     * @param EntityInterface|Host $origin
     * @return Incident
     */
    public function setOrigin(Host $origin = null): Incident
    {
        $this->setter($this->origin, $origin);
        return $this;
    }

    /**
     * @param Incident $incident_detected
     * @return Incident
     */
    public function updateFromDetection(Incident $incident_detected): Incident
    {
        $this->setState($incident_detected->getState());
        $this->updateTlp($incident_detected);
        $this->updatePriority($incident_detected);

        return $this;

    }

    /**
     * @param Incident $incidentDetected
     * @return Incident
     */
    public function updateTlp(Incident $incidentDetected): Incident
    {
        return $this->getBehavior()->updateTlp($this, $incidentDetected);

    }

    /**
     * @param Incident $incidentDetected
     * @return Incident
     */
    public function updatePriority(Incident $incidentDetected): Incident
    {
        return $this->getBehavior()->updatePriority($this, $incidentDetected);
    }

    /**
     * @return IncidentTlp
     */
    public function getTlp(): ?IncidentTlp
    {
        return $this->tlp;
    }

    /**
     * @param IncidentTlp $tlp
     * @return Incident
     */
    public function setTlp(IncidentTlp $tlp): Incident
    {
        $this->setter($this->tlp, $tlp);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastState(): ?IncidentState
    {
        return $this->getStateEdge() ? $this->getStateEdge()->getOldState() : null;
    }

    public function isDefined(): ?bool
    {
        return ($this->getOrigin() && $this->getType());
    }

    /**
     * @return array
     */
    public function getDataIdentificationArray(): array
    {
        return ['type' => $this->getType()->getId(), 'origin' => $this->getOrigin() ? $this->getOrigin()->getId() : null];
    }
}
