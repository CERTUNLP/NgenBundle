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

use CertUnlp\NgenBundle\Entity\Incident\Host\Host;
use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Model\IncidentInterface;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use CertUnlp\NgenBundle\Model\ReporterInterface;
use CertUnlp\NgenBundle\Validator\Constraints as CustomAssert;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Model\Thread;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User", inversedBy="$assignedIncidents")
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
     * @var IncidentUrgency
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency", inversedBy="incidents")
     * @ORM\JoinColumn(name="urgency", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $urgency;
    /**
     * @var IncidentImpact
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentImpact", inversedBy="incidents")
     * @ORM\JoinColumn(name="impact", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $impact;
    /**
     * @var IncidentCommentThread
     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentCommentThread",mappedBy="incident",fetch="EXTRA_LAZY"))
     */
    protected $comment_thread;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $date;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_time_detected", type="datetime",nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $lastTimeDetected;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="renotification_date", type="datetime",nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $renotificationDate;
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $createdAt;
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    protected $updatedAt;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_closed", type="boolean")
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    protected $isClosed = false;
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
    protected $sendReport = true;

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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Host\Host", inversedBy="incidents_as_origin")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $origin;
    /**
     * @var Host|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Host\Host", inversedBy="incidents_as_destination")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $destination;
    /**
     * @var NetworkInterface|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Model\NetworkInterface", inversedBy="incidents")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $network;

    /**
     * @return int
     */
    public function getId(): int
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
     * @return \DateTime
     */
    public function getRenotificationDate(): \DateTime
    {
        return $this->renotificationDate;
    }

    /**
     * @param \DateTime $renotificationDate
     * @return Incident
     */
    public function setRenotificationDate(\DateTime $renotificationDate): Incident
    {
        $this->renotificationDate = $renotificationDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Incident
     */
    public function setCreatedAt(\DateTime $createdAt): Incident
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Incident
     */
    public function setUpdatedAt(\DateTime $updatedAt): Incident
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return User
     */
    public function getReporter(): ?ReporterInterface
    {
        return $this->reporter;
    }

    /**
     * @param ReporterInterface $reporter
     * @return Incident
     */
    public function setReporter(ReporterInterface $reporter = null): Incident
    {
        $this->reporter = $reporter;
        return $this;
    }

    /**
     * @return User
     */
    public function getAssigned(): ?ReporterInterface
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
    public function getEvidenceFileTemp(): string
    {
        return $this->evidence_file_temp;
    }

    /**
     * @param string $evidence_file_temp
     * @return Incident
     */
    public function setEvidenceFileTemp(string $evidence_file_temp): Incident
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
    public function getIp(): ?string
    {
        return $this->getOrigin()->getIpV4();
    }

    /**
     * @return Host
     */
    public function getOrigin(): Host
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
     * @param bool $lastTimeDetected
     * @return int
     * @throws \Exception
     */
    public function getOpenDays(bool $lastTimeDetected = false): int
    {
        if ($lastTimeDetected) {
            $date = $this->getLastTimeDetected() ?: $this->getDate();
        } else {
            $date = $this->getDate();
        }

        if ($date) {
            return $date->diff(new \DateTime())->days;
        }
        return null;
    }

    /**
     * @return \DateTime
     */
    public function getLastTimeDetected(): \DateTime
    {
        return $this->lastTimeDetected;
    }

    /**
     * @param \DateTime $lastTimeDetected
     * @return Incident
     */
    public function setLastTimeDetected(\DateTime $lastTimeDetected): Incident
    {
        $this->lastTimeDetected = $lastTimeDetected;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Incident
     */
    public function setDate(\DateTime $date = null): Incident
    {
        $this->date = $date;
        return $this;
    }

    public function getEmails(): array
    {
        return [];
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
     * Get $state
     *
     * @return IncidentState
     */
    public function getState(): ?IncidentState
    {
        return $this->state;
    }

    /**
     * /**
     * Set state
     *
     * @param IncidentState $state
     * @return Incident
     */
    public function setState(IncidentState $state = null): Incident
    {

        if ($state && !\in_array($state->getSlug(), ['open', 'stand_by'])) {
            $this->close();
        } else {
            $this->open();
        }
        $this->state = $state;

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
        return $this->setIsClosed(false);
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
            $this->setEvidenceFilePath(null);
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
        return null;
    }

    /**
     * @param mixed $evidence_file_path
     * @return Incident
     */
    public function setEvidenceFilePath(string $evidence_file_path): Incident
    {
        $this->evidence_file_path = $evidence_file_path;
        return $this;
    }

    /**
     * Get evidence_file_path
     *
     * @return string
     */
    public function getEvidenceSubDirectory(): string
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
    public function getDestination(): Host
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
     * @return NetworkInterface
     */
    public function getNetwork(): ?NetworkInterface
    {
        return $this->network;
    }

    /**
     * @param NetworkInterface $network
     * @return Incident
     */
    public function setNetwork(NetworkInterface $network = null): Incident
    {
        $this->network = $network;
        return $this;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Incident
     */
    public function setIp(string $ip): Incident
    {
        return $this;
    }
}
