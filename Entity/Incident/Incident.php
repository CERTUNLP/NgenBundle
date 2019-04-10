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
use CertUnlp\NgenBundle\Entity\Network\Host\Host;
use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Model\IncidentInterface;
use CertUnlp\NgenBundle\Validator\Constraints as CustomAssert;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use FOS\CommentBundle\Model\Thread;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use function in_array;

/**
 * @ORM\Entity()
 * @ORM\EntityListeners({ "CertUnlp\NgenBundle\Entity\Incident\Listener\InternalIncidentListener" })
 * @ORM\HasLifecycleCallbacks
 * @JMS\ExclusionPolicy("all")
 * @CustomAssert\TypeHasReport
 */
class Incident implements IncidentInterface
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    protected $id;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User", inversedBy="incidents")
     */
    protected $reporter;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User", inversedBy="assignedIncidents")
     */
    protected $assigned;
    /**
     * @var IncidentType
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType",inversedBy="incidents")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $type;
    /**
     * @var IncidentFeed
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentFeed", inversedBy="incidents")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @Assert\NotNull
     */
    protected $feed;
    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState", inversedBy="incidents")
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $state;
    /**
     * @var IncidentTlp
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentTlp", inversedBy="incidents")
     * @ORM\JoinColumn(name="tlp_state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $tlp;

    /**
     * @var IncidentPriority
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentPriority", inversedBy="incidents")
     * @ORM\JoinColumn(name="priority", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $priority;
    /**
     * @var IncidentImpact
     */
    protected $impact;
    /**
     * @var IncidentUrgency
     */
    protected $urgency;
    /**
     * @var IncidentCommentThread
     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentCommentThread",mappedBy="incident",fetch="EXTRA_LAZY"))
     */
    protected $comment_thread;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $date;

    /**
     * @var Collection
     * @JMS\Expose
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentLastTimeDetected",mappedBy="incident",cascade={"persist"},orphanRemoval=true)
     * @JMS\Groups({"api"})
     */
    protected $lastTimeDetected;

    /**
     * @var Collection
     * @JMS\Expose
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentChangeState",mappedBy="incident",cascade={"persist"},orphanRemoval=true)
     * @JMS\Groups({"api"})
     */
    protected $changeStateHistory;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="renotification_date", type="datetime",nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $renotificationDate;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $createdAt;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $updatedAt;

    /**
     * @var DateTime
     * @ORM\Column(name="opened_at", type="datetime", nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $openedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_closed", type="boolean")
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    protected $isClosed = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_new", type="boolean")
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    protected $isNew = true;

    /**
     * @var boolean
     *
     */
    protected $needToCommunicate = false;

    /**
     * @return bool
     */
    public function isNeedToCommunicate(): bool
    {
        return $this->needToCommunicate;
    }

    /**
     * @param bool $needToCommunicate
     */
    public function setNeedToCommunicate(bool $needToCommunicate): void
    {
        $this->needToCommunicate = $needToCommunicate;
    }


    /**
     * @Assert\File(maxSize = "500k")
     */
    protected $evidence_file;
    /**
     * @ORM\Column(name="evidence_file_path", type="string",nullable=true)
     */
    protected $evidence_file_path;
    /**
     * @var string
     * @ORM\Column(name="report_message_id", type="string",nullable=true)
     */
    protected $report_message_id;
    /**
     * @var $evidence_file_temp
     */
    protected $evidence_file_temp;
    /**
     * @var bool
     */
    protected $sendReport = false;
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"id"},separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * */
    protected $slug;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $notes;
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
        $this->lastTimeDetected=new ArrayCollection();
        $this->changeStateHistory=new ArrayCollection();
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
        $this->id = $id;
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
        $this->renotificationDate = $renotificationDate;
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
     * @return Incident
     */
    public function setCreatedAt(DateTime $createdAt): Incident
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
     * @return Incident
     */
    public function setUpdatedAt(DateTime $updatedAt): Incident
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->isClosed;
    }

    /**
     * @param bool $isClosed
     * @return Incident
     */
    public function setIsClosed(bool $isClosed): Incident
    {
        $this->isClosed = $isClosed;
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
        $this->feed = $feed;
        return $this;
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
        $this->tlp = $tlp;
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
        $this->urgency = $urgency;
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
        $this->impact = $impact;
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
        $this->report_message_id = $report_message_id;
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
        $this->evidence_file_temp = $evidence_file_temp;
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
        $this->comment_thread = $comment_thread;
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
        $this->notes = $notes;
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
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param bool $lastTimeUpdated
     * @return int
     * @throws Exception
     */
    public function getOpenDays(bool $lastTimeDetected = false): int
    {
        if ($lastTimeDetected) {
            $date = $this->getOpenedAt()?: $this->getDate();
        } else {
            $date = $this->getDate();
        }

        if ($date) {
            return $date->diff(new DateTime())->days;
        }
        return null;
    }

    /**
     * @param bool $lastTimeDetected
     * @return int
     * @throws Exception
     */
    public function getResponseMinutes(bool $lastTimeDetected = false): int
    {
        if (!$this->isNew()){
            return abs((($this->getDate())->getTimestamp()-($this->getOpenedAt())->getTimestamp())/60); //lo devuelvo en minutos eso es el i
        }
        else
            {
                return abs(((new DateTime())->getTimestamp()-($this->getDate())->getTimestamp())/60);
        }
    }

    /**
     * @param bool $lastTimeDetected
     * @return int
     * @throws Exception
     */
    public function getResolutionMinutes(bool $lastTimeDetected = false):int
    {
        if (!$this->isClosed()) {
            if (!$this->isNew()) {
                return abs(((new DateTime())->getTimestamp()-($this->getOpenedAt())->getTimestamp())/60); //lo devuelvo en minutos eso es el i
            } else {
                return 0;
            }
        }
        else
        {
            return abs((($this->getUpdatedAt()->getTimestamp())-($this->getOpenedAt())->getTimestamp())/60);

        }
    }
    /**
     * @param bool $lastTimeDetected
     * @return int
     * @throws Exception
     */
    public function getNewMinutes(bool $lastTimeDetected = false): int
    {
        if ($this->isNew()){
            return $this->getDate()->diff(new DateTime())->i; //lo devuelvo en minutos eso es el i
        }
        else{ return 0;}
    }
    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLastTimeDetected()
    {
        return $this->lastTimeDetected;
    }

    /**
     * @param ArrayCollection $lastTimeDetectedCollection
     */

    public function setLastTimeDetected(ArrayCollection $lastTimeDetectedCollection): void
    {
        $this->lastTimeDetected = $lastTimeDetectedCollection;
    }

    /**
     * @param IncidentLastTimeDetected $lastTimeDetected
     * @return Incident
     */
    public function addLastTimeDetected(IncidentFeed $feed): Incident
    {
        $this->lastTimeDetected[] = new IncidentLastTimeDetected($this,$feed);
        return $this;
    }
    /**
     * @return ArrayCollection
     */
    public function getChangeStateHistory()
    {
        return $this->changeStateHistory;
    }

    /**
     * @param ArrayCollection $changeStateHistory
     */
    public function setChangeStateHistory(ArrayCollection $changeStateHistory): void
    {
        $this->changeStateHistory = $changeStateHistory;
    }


    /**
     * @param IncidentChangeState $changeState
     * @return Incident
     */
    public function addChangeStateHistory(IncidentChangeState $changeState): Incident
    {
        $this->changeStateHistory[] = $changeState;
        return $this;
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
        $this->date = $date;
        return $this;
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
        if ($this->getAssigned() && $this->getState()->getMailAssigned()->getLevel() >= $this->getPriority()->getCode()) {
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
        $this->assigned = $assigned;
        return $this;
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
     * @param User $reporter
     * @return Incident
     */
    public function setStateAndReporter(IncidentState $state = null,User $reporter): Incident
    {
        ////FIX hay que trabajar el flujo del estado del incidente DAMIAN HELP

        if ($state->isOpening() and $this->isNew()){
            $this->open();
        }
        if ($state->isReOpening() and $this->isClosed()){
            $this->reOpen();
        }
        if ($state->isClosing()){
            $this->close();
        }
        $this->addChangeStateHistory(new IncidentChangeState($this,$this->getState(),$reporter,$state));
        $this->setState($state) ;
        return $this;
    }

    /**
     * Set state
     * @param IncidentState $state
     * @return Incident
     */
    public function setState(IncidentState $state = null): Incident
    {
        $this->state=$state;
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
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getReporterContacts(): ArrayCollection
    {
        if ($this->getReporter() && $this->getState()->getMailReporter()->getLevel() >= $this->getPriority()->getCode()) {
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
        $this->reporter = $reporter;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getNetworkAdminContacts(): ArrayCollection
    {
        if ($this->getNetworkAdmin() && $this->getState()->getMailAdmin()->getLevel() >= $this->getPriority()->getCode()) {
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
        $this->network = $network;
        return $this;
    }

    /**
     * @return Incident
     */
    public function close(): Incident
    {
        return $this->setIsClosed(true);
    }

    /**
     * @return Incident
     */
    public function open(): Incident
    {
        $this->setNeedToCommunicate(true);
        $this->setOpenedAt(new DateTime('now'));
        return $this->setIsNew(false);
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->getState()->getSlug() === 'open';
    }

    /**
     * @return Incident
     */
    public function reOpen(): Incident
    {
        $this->setNeedToCommunicate(true);
        return $this->setIsClosed(false);
    }
    /**
     * @return array
     */
    public function getEmails(): array
    {
        return array_filter($this->getEmailContacts()->map(function (Contact $contact) {
            return $contact->getEmail();
        })->toArray(), function ($value) {
            return $value !== '';
        });
    }

    /**
     * @return ArrayCollection
     */
    public function getEmailContacts(): ArrayCollection
    {
        return $this->getContacts()->filter(function (Contact $contact) {
            return $contact->getEmail();
        });
    }

    /**
     * @return bool
     */
    public function canBeSended(): bool

    {
        return !$this->isStaging() && !$this->isUndefined();
    }

    /**
     * @return bool
     */
    public function isStaging(): bool
    {
        return $this->getState()->getSlug() === 'staging';
    }

    /**
     * @return bool
     */
    public function isUndefined(): bool
    {
        return $this->getType()->getSlug() === 'undefined';

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
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function getTelegrams(): array
    {
        return array_filter($this->getTelegramContacts()->map(function (Contact $contact) {
            return $contact->getTelegram();
        })->toArray(), function ($value) {
            return $value !== '';
        });
    }

    /**
     * @return ArrayCollection
     */
    public function getTelegramContacts(): ArrayCollection
    {
        return $this->getContacts()->filter(function (Contact $contact) {
            return $contact->getTelegram();
        });
    }

    public function isInternal(): bool
    {
        return false;
    }

    public function isExternal(): bool
    {
        return false;
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
        $this->evidence_file = $evidenceFile;
// check if we have an old image path
        if ($this->getEvidenceFilePath()) {
// store the old name to delete after the update
            $this->setEvidenceFileTemp($this->getEvidenceFilePath());
            $this->setEvidenceFilePath();
        } else {
            $this->setEvidenceFilePath('initial');
        }
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

            return $pre_path . $this . $this->evidence_file_path;
        }
        return '';
    }

    /**
     * @param mixed $evidence_file_path
     * @return Incident
     */
    public function setEvidenceFilePath(string $evidence_file_path = null): Incident
    {
        $this->evidence_file_path = $evidence_file_path;
        return $this;
    }

    /**
     * Get evidence_file_path
     *
     * @return string
     */
    public function getEvidenceSubDirectory(): ?string
    {
        return '/' . $this->getDate()->format('Y') . '/' . $this->getDate()->format('F') . '/' . $this->getDate()->format('d');
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
        $this->sendReport = $sendReport;
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
        $this->destination = $destination;
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
        if ($this->getOrigin()) {
            $this->getOrigin()->setAddress($address);

        } else {
            $this->address = $address;
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
    public function setOrigin(Host $origin): Incident
    {
        $this->origin = $origin;
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
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->isNew;
    }

    /**
     * @param bool $isNew
     */
    public function setIsNew($isNew=true): Incident
    {
        $this->isNew = $isNew;
        $this->setOpenedAt(new DateTime());
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getOpenedAt()
    {
        return $this->openedAt;
    }

    /**
     * @param DateTime $openedAt
     */
    public function setOpenedAt($openedAt)
    {
        $this->openedAt = $openedAt;
    }

}
