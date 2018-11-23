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

use CertUnlp\NgenBundle\Entity\Incident\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Model\IncidentInterface;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use CertUnlp\NgenBundle\Model\ReporterInterface;
use CertUnlp\NgenBundle\Validator\Constraints as CustomAssert;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Model\Thread;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 * @JMS\ExclusionPolicy("all")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"incident"="incident","internal" = "InternalIncident", "external" = "ExternalIncident"})
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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User", inversedBy="incidents")
     */
    protected $reporter;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User", inversedBy="$assignedIncidents")
     */
    protected $assigned;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_closed", type="boolean")
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    protected $isClosed = false;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType",inversedBy="incidents")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $type;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentFeed", inversedBy="incidents")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @Assert\NotNull
     */
    protected $feed;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState", inversedBy="incidents")
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $state;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentTlp", inversedBy="incidents")
     * @ORM\JoinColumn(name="tlp_state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $tlpState;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency", inversedBy="incidents")
     * @ORM\JoinColumn(name="urgency", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $urgency;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentImpact", inversedBy="incidents")
     * @ORM\JoinColumn(name="impact", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $impact;

    /**
     * @Assert\File(maxSize = "500k")
     */

    protected $evidence_file;
    /**
     * @ORM\Column(name="evidence_file_path", type="string",nullable=true)
     */
    protected $evidence_file_path;
    /**
     * @ORM\Column(name="report_message_id", type="string",nullable=true)
     */
    protected $report_message_id;
    /**
     * @var $evidence_file_temp
     */
    protected $evidence_file_temp;
    /**
     * @var $sendReport
     */
    protected $sendReport;
    /**
     * @var $report_edit
     */
    protected $report_edit;
    /**
     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentCommentThread",mappedBy="incident",fetch="EXTRA_LAZY"))
     */
    protected $comment_thread;
    protected $hostAddress;
    protected $slug;
    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    protected $notes;

    /**
     * @return mixed
     */
    public function getAssigned()
    {
        return $this->assigned;
    }

    /**
     * @param mixed $assigned
     */
    public function setAssigned($assigned)
    {
        $this->assigned = $assigned;
    }

    /**
     * @return mixed
     */
    public function getTlpState()
    {
        return $this->tlpState;
    }

    /**
     * @param $tlpState
     * @return Incident
     */
    public function setTlpState($tlpState)
    {
        $this->tlpState = $tlpState;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get hostAddress
     *
     * @return string
     */
    public function getHostAddress()
    {
        return $this->hostAddress;
    }

    /**
     * Set hostAddress
     *
     * @param string $hostAddress
     * @return Incident
     */
    public function setHostAddress($hostAddress)
    {
        $this->hostAddress = $hostAddress;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Incident
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Incident
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get isClosed
     *
     * @return boolean
     */
    public function getIsClosed()
    {
        return $this->isClosed;
    }

    /**
     * Get isClosed
     *
     * @return boolean
     */
    public function isClosed()
    {
        return $this->getIsClosed();
    }

    /**
     * Set isClosed
     *
     * @param boolean $isClosed
     * @return Incident
     */
    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;

        return $this;
    }

    /**
     * Get type
     *
     * @return IncidentType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param IncidentType $type
     * @return Incident
     */
    public function setType(IncidentType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    public function __toString()
    {
        return $this->getSlug();
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Incident
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get reporter
     *
     * @return \CertUnlp\NgenBundle\Model\ReporterInterface
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * Set reporter
     *
     * @param \CertUnlp\NgenBundle\Model\ReporterInterface $reporter
     * @return Incident
     */
    public function setReporter(ReporterInterface $reporter = null)
    {
        $this->reporter = $reporter;

        return $this;
    }

    /**
     * Get evidence_file
     *
     * @return string
     */
    public function getEvidenceFile()
    {
        return $this->evidence_file;
    }

    /**
     * Set evidence_file
     *
     * @param File $evidenceFile
     * @return Incident
     */
    public function setEvidenceFile(File $evidenceFile = null)
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
    public function getEvidenceFilePath(string $fullPath = null)
    {

        if ($this->evidence_file_path) {

            if ($fullPath) {
                $pre_path = $this->getEvidenceSubDirectory() . "/";
            } else {
                $pre_path = "";
            }

            return $pre_path . $this . $this->evidence_file_path;
        }
        return null;
    }

    /**
     * Set evidence_file_path
     *
     * @param string $evidenceFilePath
     * @return Incident
     */
    public function setEvidenceFilePath(string $evidenceFilePath)
    {
        $this->evidence_file_path = $evidenceFilePath;

        return $this;
    }

    /**
     * Get evidence_file_path
     *
     * @return string
     */
    public function getEvidenceSubDirectory()
    {
        return '/' . $this->getDate()->format('Y') . '/' . $this->getDate()->format('F') . '/' . $this->getDate()->format('d');
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Incident
     */

    public function setDate(DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get evidence_file_temp
     *
     * @return string
     */
    public function getEvidenceFileTemp()
    {
        return $this->evidence_file_temp;
    }

    /**
     * Set evidence_file_temp
     *
     * @param string $evidenceFileTemp
     * @return Incident
     */
    public function setEvidenceFileTemp(string $evidenceFileTemp)
    {
        $this->evidence_file_temp = $evidenceFileTemp;

        return $this;
    }

    /**
     * Get state
     *
     * @return IncidentState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state
     *
     * @param IncidentState $state
     * @return Incident
     */
    public function setState(IncidentState $state = null)
    {
        if (!in_array($state->getSlug(), ['open', 'stand_by'])) {
            $this->close();
        } else {
            $this->open();
        }
        $this->state = $state;

        return $this;
    }

    public function close()
    {
        $this->setIsClosed(true);
    }

    public function open()
    {
        $this->setIsClosed(false);
    }

    public function getOpenDays($lastTimeDetected = false)
    {
        if ($lastTimeDetected) {
            $date = $this->getLastTimeDetected() ? $this->getLastTimeDetected() : $this->getDate();
        } else {
            $date = $this->getDate();
        }
        $diff = $date->diff(new \DateTime());
        return $diff->days;
    }

    /**
     * Get lastTimeDetected
     *
     * @return \DateTime
     */
    public function getLastTimeDetected()
    {
        return $this->lastTimeDetected;
    }

    /**
     * Set lastTimeDetected
     *
     * @param \DateTime $lastTimeDetected
     * @return Incident
     */
    public function setLastTimeDetected($lastTimeDetected)
    {
        $this->lastTimeDetected = $lastTimeDetected;

        return $this;
    }

    /**
     * Get sendReport
     *
     * @return boolean
     */
    public function getSendReport()
    {
        return $this->sendReport;
    }

    /**
     * Set report_sent
     *
     * @param boolean $sendReport
     * @return Incident
     */
    public function setSendReport(bool $sendReport)
    {
        $this->sendReport = $sendReport;

        return $this;
    }

    /**
     * Get feed
     *
     * @return IncidentFeed
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * Set feed
     *
     * @param IncidentFeed $feed
     * @return Incident
     */
    public function setFeed(IncidentFeed $feed = null)
    {
        $this->feed = $feed;

        return $this;
    }

    /**
     * Get evidence_file
     *
     * @return string
     */
    public function getReportEdit()
    {
        return $this->report_edit;
    }

    /**
     * Get evidence_file
     *
     * @param $report_edit
     * @return string
     */
    public function setReportEdit($report_edit)
    {
        $this->report_edit = $report_edit;
        return $this;
    }

    /**
     * Get renotificationDate
     *
     * @return \DateTime
     */
    public function getRenotificationDate()
    {
        return $this->renotificationDate;
    }

    /**
     * Set renotificationDate
     *
     * @param \DateTime $renotificationDate
     * @return Incident
     */
    public function setRenotificationDate($renotificationDate)
    {
        $this->renotificationDate = $renotificationDate;

        return $this;
    }

    /**
     * Get report_message_id
     *
     * @return string
     */
    public function getReportMessageId()
    {
        return $this->report_message_id;
    }

    /**
     * Set report_message_id
     *
     * @param string $reportMessageId
     * @return Incident
     */
    public function setReportMessageId(string $reportMessageId)
    {
        $this->report_message_id = $reportMessageId;

        return $this;
    }

    /**
     * Set network
     *
     * @param \CertUnlp\NgenBundle\Model\NetworkInterface $network
     * @return void
     */
    public function setNetwork(NetworkInterface $network = null)
    {

    }

    public function setNetworkAdmin(NetworkAdmin $networkAdmin)
    {
        // TODO: Implement setNetworkAdmin() method.
    }

    /**
     * Get network
     *
     * @return void
     */
    public function getNetwork()
    {

    }

    /**
     * Get network
     *
     */
    public function getNetworkAdmin()
    {

    }

    /**
     * Get commentThread
     *
     * @return IncidentCommentThread
     */
    public function getCommentThread()
    {
        return $this->comment_thread;
    }

    /**
     * Set commentThread
     *
     * @param Thread $commentThread
     *
     * @return Incident
     */
    public function setCommentThread(Thread $commentThread = null)
    {
        $this->comment_thread = $commentThread;

        return $this;
    }

    public function getEmails()
    {
        return [];
    }

    public function isInternal()
    {
        return false;
    }

    public function isExternal()
    {
        return false;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Incident
     */

    public function setNotes($notes)
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImpact()
    {
        return $this->impact;
    }

    /**
     * @param mixed $impact
     */
    public function setImpact($impact): void
    {
        $this->impact = $impact;
    }

    /**
     * @return mixed
     */
    public function getUrgency()
    {
        return $this->urgency;
    }

    /**
     * @param mixed $urgency
     */
    public function setUrgency($urgency): void
    {
        $this->urgency = $urgency;
    }
}
