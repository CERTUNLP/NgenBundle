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

use CertUnlp\NgenBundle\Entity\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Incident\State\Behavior\StateBehavior;
use CertUnlp\NgenBundle\Entity\Incident\State\Edge\StateEdge;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\Network\Host\Host;
use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Validator\Constraints as CustomAssert;
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
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IncidentRepository")
 * @ORM\EntityListeners({ "CertUnlp\NgenBundle\Entity\Incident\Listener\InternalIncidentListener" })
 * @ORM\HasLifecycleCallbacks
 * @JMS\ExclusionPolicy("all")
 */
class Incident
{
    /**
     * @var string
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $temporalNotes;
    /**
     * @var string
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $temporalEvidenceFile;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="response_dead_line", type="datetime",nullable=true))
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $responseDeadLine;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="solve_dead_line", type="datetime",nullable=true))
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $solveDeadLine;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    private $id;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User", inversedBy="incidents")
     * @JMS\Expose
     */
    private $reporter;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User", inversedBy="assignedIncidents")
     * @JMS\Expose
     */
    private $assigned;
    /**
     * @var IncidentType
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType",inversedBy="incidents")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @CustomAssert\TypeHasReport
     */
    private $type;
    /**
     * @var IncidentFeed
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentFeed", inversedBy="incidents")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @Assert\NotNull
     */
    private $feed;
    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $state;
    /**
     * @var IncidentState
     */
    private $lastState;
    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="unattended_state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $unattendedState;
    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="unsolved_state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $unsolvedState;
    /**
     * @var User
     */
    private $reportReporter;
    /**
     * @var IncidentTlp
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentTlp", inversedBy="incidents")
     * @ORM\JoinColumn(name="tlp_state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $tlp;
    /**
     * @var IncidentPriority
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentPriority", inversedBy="incidents")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $priority;
    /**
     * @var IncidentImpact
     */
    private $impact;
    /**
     * @var IncidentUrgency
     */
    private $urgency;
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
     * @JMS\Groups({"api"})
     */
    private $date;
    /**
     * @var Collection
     * @JMS\Expose
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentDetected",mappedBy="incident",cascade={"persist"},orphanRemoval=true)
     * @JMS\Groups({"api"})
     */
    private $incidentsDetected;
    /**
     * @var Collection
     * @JMS\Expose
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentChangeState",mappedBy="incident",cascade={"persist"},orphanRemoval=true)
     * @JMS\Groups({"api"})
     */
    private $changeStateHistory;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="renotification_date", type="datetime",nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    private $renotificationDate;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    private $createdAt;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    private $updatedAt;

    /**
     * @var boolean
     */
    private $needToCommunicate = false;
    /**
     * @Assert\File(maxSize = "500k")
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
     * @var $evidence_file_temp
     */
    private $evidence_file_temp;
    /**
     * @var bool
     */
    private $sendReport = false;
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"id"},separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * */
    private $slug;
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
     * @var Host|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\Host\Host", inversedBy="incidents_as_origin")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $origin;
    /**
     * @var Host|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\Host\Host", inversedBy="incidents_as_destination")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $destination;
    /**
     * @var Network|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\Network", inversedBy="incidents")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $network;
    /**
     * @CustomAssert\ValidAddress()
     */
    private $address;

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
        $this->changeStateHistory = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getTemporalNotes(): ?string
    {
        return $this->temporalNotes;
    }

    /**
     * @param string $temporalNotes
     * @return Incident
     */
    public function setTemporalNotes(string $temporalNotes): self
    {
        $this->temporalNotes = $temporalNotes;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemporalEvidenceFile(): ?string
    {
        return $this->temporalEvidenceFile;
    }

    /**
     * @param string $temporalEvidenceFile
     * @return Incident
     */
    public function setTemporalEvidenceFile(string $temporalEvidenceFile): self
    {
        $this->temporalEvidenceFile = $temporalEvidenceFile;
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
     */
    public function setResponseDeadLine(DateTime $responseDeadLine = null): void
    {
        $this->responseDeadLine = $responseDeadLine;
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
     */
    public function setSolveDeadLine(DateTime $solveDeadLine = null): void
    {
        $this->solveDeadLine = $solveDeadLine;
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
     */
    public function setUnattendedState(IncidentState $unattendedState = null): void
    {
        $this->unattendedState = $unattendedState;
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
     */
    public function setUnsolvedState(IncidentState $unsolvedState = null): void
    {
        $this->unsolvedState = $unsolvedState;
    }

    /**
     * @return bool
     */
    public function canEdit(): bool
    {
        return $this->getBehavior()->canEdit();
    }

    /**
     * @return StateBehavior
     */
    public function getBehavior(): ?StateBehavior
    {
        return $this->getState() ? $this->getState()->getBehavior() : null;
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
            return $this->getState()->changeIncidentState($this, $state);
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
     * @return bool
     */
    public function canEditFundamentals(): bool
    {
        return $this->getBehavior()->canEditFundamentals();
    }

    /**
     * @return mixed
     */
    public function getReportReporter(): ?User
    {
        return $this->reportReporter;
    }

    /**
     * @param mixed $reportReporter
     * @return Incident
     */
    public function setReportReporter(User $reportReporter): Incident
    {
        $this->setter($this->reportReporter, $reportReporter);
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
     * @param IncidentChangeState $changeState
     * @return Incident
     */
    public function addChangeStateHistory(IncidentChangeState $changeState): Incident
    {
        return $this->getBehavior()->addChangeStateHistory($this, $changeState);
    }

    /**
     * @return Collection| IncidentDetected[]
     */
    public function getIncidentsDetected(): ?Collection
    {
        return $this->incidentsDetected;
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
     * @return Incident
     */
    public function setId(int $id): Incident
    {
        $this->setter($this->id, $id);
        return $this;
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
     * @param IncidentUrgency $urgency
     * @return Incident
     */
    public function setUrgency(IncidentUrgency $urgency): Incident
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
    public function setImpact(IncidentImpact $impact): Incident
    {
        $this->setter($this->impact, $impact);
        return $this;
    }

    /**
     * @return string
     */
    public function getReportMessageId(): string
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
     * @return string
     */
    public function getEvidenceFileTemp(): ?string
    {
        return $this->evidence_file_temp;
    }

    /**
     * @param string $evidence_file_temp
     * @return Incident
     */
    public function setEvidenceFileTemp(string $evidence_file_temp = null): Incident
    {
        $this->setter($this->evidence_file_temp, $evidence_file_temp);
        return $this;
    }

    /**
     * @return IncidentCommentThread
     */
    public function getCommentThread(): IncidentCommentThread
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
        $this->setter($this->temporalNotes, $notes);
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
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return Incident
     */
    public function setUpdatedAt(DateTime $updatedAt): Incident
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
     * @return int
     * @throws Exception
     * @example if int positive incident is on time, if int is negative incident is delayed
     */
    public function getResponseDelayedDate()
    {
        $fecha = new DateTime();
        $minutes = $this->getResponseDelayedMinutes();
        $intervalo = 'PT' . ($minutes >= 0 ? $minutes : $minutes * -1) . 'M';
        $date_interval = new \DateInterval($intervalo);
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
        $minutes = $this->getPriority()->getResponseTime() - ((new DateTime())->getTimestamp() - $this->getCreatedAt()->getTimestamp()) / 60;
        return $minutes;

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
     * @return Incident
     */
    public function setCreatedAt(DateTime $createdAt): Incident
    {
        $this->setter($this->createdAt, $createdAt);
        return $this;
    }

    /**
     * @return int
     * @throws Exception
     * @example if int positive incident is on time, if int is negative incident is delayed
     */
    public function getResolutionDelayedDate()
    {
        $fecha = new DateTime();
        $minutes = $this->getResolutionDelayedMinutes();

        $intervalo = 'PT' . ($minutes >= 0 ? $minutes : $minutes * -1) . 'M';
        $date_interval = new \DateInterval($intervalo);
        $fecha->sub($date_interval);

        return $fecha->diff(new DateTime());
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getResolutionDelayedMinutes(): int
    {
        $minutes = $this->getPriority()->getResolutionTime() - $this->getResolutionMinutes();

        return $minutes;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getResolutionMinutes(): int
    {
        return $this->getResolvedTime() / 60;
    }

    /**
     * @return int
     */
    public function getResolvedTime(): int
    {
        if ($this->getResolvedDate()) {
            return abs($this->getResolvedDate()->getTimestamp() - $this->getCreatedAt()->getTimestamp());
        }
        return 0;
    }

    /**
     * @return DateTime|null
     */
    public function getResolvedDate(): ?DateTime
    {
        if (!$this->getResolvedChangeStates()->isEmpty()) {
            return $this->getResolvedChangeStates()->last()->getDate();
        }
        return null;
    }

    /**
     *
     * i->s
     * s->o   respos 1-2
     * o->o
     * o->c   resolve 1-4
     * @return IncidentChangeState[] | Collection
     */
    public function getResolvedChangeStates(): Collection
    {
        if ($this->getChangeStateHistory()) {
            return $this->getChangeStateHistory()->filter(static function (IncidentChangeState $changeState) {
                return !$changeState->getNewState()->isResolved();
            });
        }
        return new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getChangeStateHistory(): Collection
    {
        return $this->changeStateHistory;
    }

    /**
     * @param ArrayCollection $changeStateHistory
     */
    public function setChangeStateHistory(ArrayCollection $changeStateHistory): void
    {
        $this->setter($this->changeStateHistory, $changeStateHistory);
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

        return 0;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getResponsedDate(): DateTime
    {
        if (!$this->getAttendedChangeStates()->isEmpty()) {
            return $this->getAttendedChangeStates()->last()->getDate();
        }
        return new DateTime();
    }

    /**
     * @return IncidentChangeState[] | Collection
     */
    public function getAttendedChangeStates(): Collection
    {
        if ($this->getChangeStateHistory()) {
            return $this->getChangeStateHistory()->filter(static function (IncidentChangeState $changeState) {
                return !$changeState->getNewState()->isAttended();
            });
        }
        return new ArrayCollection();
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
     * @return bool
     */
    public function canCommunicate(): bool

    {
        return $this->isSendReport() && $this->getBehavior()->canComunicate() && $this->isNeedToCommunicate();
    }

    /**
     * @return bool
     */
    public function isSendReport(): bool
    {
        return $this->sendReport;
    }

    /**
     * @param bool $sendReport
     * @return Incident
     */
    public function setSendReport(bool $sendReport): Incident
    {
        $this->setter($this->sendReport, $sendReport);
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
     * @param File $evidenceFile
     * @return Incident
     */
    public function setEvidenceFile(File $evidenceFile = null): Incident
    {
        $this->setter($this->temporalEvidenceFile, $evidenceFile);
//        $this->setEvidenceFilePath($evidenceFile->getFilename());
        return $this;
    }

    /**
     * Get evidence_file_path
     *
     * @param string $fullPath
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
        //return '/'.$this->getId().$this->getSlug();//sha1(sha1($this->getId()).sha1($this->getSlug()));
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
     * @param DateTime $date
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
     * @param Host $origin
     * @return Incident
     */
    public function setOrigin(Host $origin = null): Incident
    {
        $this->setter($this->origin, $origin);
        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): ?string
    {
        return $this->getAddress();
    }

    /**
     * @param Incident $incident
     * @return Incident
     */
    public function updateVariables(Incident $incident): Incident
    {
        $this->setStateAndReporter($incident->getState(), $incident->getReporter());
        $this->updateTlp($incident);
        $this->updatePriority($incident);

        return $this;

    }

    /**
     * Set state
     * @param IncidentState $state
     * @param User $reporter
     * @return Incident
     */
    public function setStateAndReporter(IncidentState $state, User $reporter): Incident
    {
        $this->setReportReporter($reporter);
        $this->setState($state);
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

    public function patchStateAndReporter(User $reporter): Incident
    {
        if ($this->getLastState() && ($this->getState() !== $this->getLastState())) {
            $this->setStateAndReporter($this->getState(), $reporter);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastState(): IncidentState
    {
        return $this->getStateEdge() ? $this->getStateEdge()->getOldState() : null;
    }

    /**
     * @return StateEdge
     */
    public function getStateEdge(): ?StateEdge
    {
        if ($this->getChangeStateHistory()) {
            return $this->getChangeStateHistory()->last() ? $this->getChangeStateHistory()->last()->getStateEdge() : null;

        }
        return null;
    }

    public function isDefined(): ?bool
    {
        return ($this->getOrigin() && $this->getType());
    }

    /**
     * @return IncidentType
     */
    public function getType(): ?IncidentType
    {
        return $this->type;
    }

    /**
     * @param IncidentType $type
     * @return Incident
     */
    public function setType(IncidentType $type = null): Incident
    {
        $this->setter($this->type, $type, true);
        return $this;
    }
}
