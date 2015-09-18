<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CertUnlp\NgenBundle\Validator\Constraints as NetworkAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use CertUnlp\NgenBundle\Model\ReporterInterface;
use CertUnlp\NgenBundle\Model\IncidentInterface;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use JMS\Serializer\Annotation as JMS;

/**
 * Incident
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Entity\IncidentRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\EntityListeners({ "CertUnlp\NgenBundle\Entity\Listener\IncidentListener" })
 * @JMS\ExclusionPolicy("all")
 * 
 */
class Incident implements IncidentInterface {

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
     * @var string
     *
     * @ORM\Column(name="host_address", type="string", length=20)
     * @NetworkAssert\Ip
     * @NetworkAssert\ValidNetwork
     * @JMS\Expose
     */
    private $hostAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_time_detected", type="datetime",nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $lastTimeDetected;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="renotification_date", type="datetime",nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $renotificationDate;

    /**
     * @var string
     * 
     * @Gedmo\Slug(fields={"hostAddress"},separator="_")     
     * @ORM\Column(name="slug", type="string", length=100,nullable=true,unique=true)
     * @JMS\Expose
     * */
    private $slug;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Model\NetworkInterface", inversedBy="incidents") 
     * @JMS\Expose
     * @JMS\Type("CertUnlp\NgenBundle\Entity\Network")     
     */
    private $network;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\NetworkAdmin", inversedBy="incidents")    
     * @JMS\Expose
     * @JMS\Type("CertUnlp\NgenBundle\Entity\NetworkAdmin")
     */
    private $networkAdmin;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\AcademicUnit", inversedBy="incidents") 
     * @JMS\Expose
     * @JMS\Type("CertUnlp\NgenBundle\Entity\AcademicUnit")
     */
    private $academicUnit;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Model\ReporterInterface", inversedBy="incidents") 
     */
    private $reporter;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_closed", type="boolean")
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    private $isClosed = false;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentType")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Type("CertUnlp\NgenBundle\Entity\IncidentType")
     * @JMS\Expose
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentFeed") 
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @JMS\Type("CertUnlp\NgenBundle\Entity\IncidentType")
     * @JMS\Expose
     */
    private $feed;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentState") 
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     * @JMS\Type("CertUnlp\NgenBundle\Entity\IncidentType")
     * @JMS\Expose
     */
    private $state;

    /**
     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentCommentThread",mappedBy="incident", fetch="EXTRA_LAZY")
     */
    private $comment_thread;

    /**
     * @var integer
     *
     * @ORM\Column(name="redmine_issue_id", type="integer",nullable=true)
     */
    private $redmine_issue_id;

    /**
     * @var Issue
     *
     */
    private $redmine_issue;

    /**
     * @Assert\File(maxSize = "500k")
     */
    private $evidence_file;

    /**
     * @ORM\Column(name="evidence_file_path", type="string",nullable=true)
     */
    private $evidence_file_path;

    /**
     * @ORM\Column(name="report_message_id", type="string",nullable=true)
     */
    private $report_message_id;

    /**
     * @var $evidence_file_temp
     */
    private $evidence_file_temp;

    /**
     * @var $sendReport
     */
    private $sendReport;

    /**
     * @var $report_edit
     */
    private $report_edit;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set hostAddress
     *
     * @param string $hostAddress
     * @return Incident
     */
    public function setHostAddress($hostAddress) {
        $this->hostAddress = $hostAddress;
        return $this;
    }

    /**
     * Get hostAddress
     *
     * @return string 
     */
    public function getHostAddress() {
        return $this->hostAddress;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Incident
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Incident
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set isClosed
     *
     * @param boolean $isClosed
     * @return Incident
     */
    public function setIsClosed($isClosed) {
        $this->isClosed = $isClosed;

        return $this;
    }

    /**
     * Get isClosed
     *
     * @return boolean 
     */
    public function getIsClosed() {
        return $this->isClosed;
    }

    /**
     * Get isClosed
     *
     * @return boolean 
     */
    public function isClosed() {
        return $this->getIsClosed();
    }

    /**
     * Set network
     *
     * @param \CertUnlp\NgenBundle\Model\NetworkInterface $network
     * @return Incident
     */
    public function setNetwork(NetworkInterface $network = null) {
        $this->network = $network;
        $this->setNetworkAdmin($network->getNetworkAdmin());
        $this->setAcademicUnit($network->getAcademicUnit());

        return $this;
    }

    /**
     * Get network
     *
     * @return \CertUnlp\NgenBundle\Model\NetworkInterface} 
     */
    public function getNetwork() {
        return $this->network;
    }

    /**
     * Set type
     *
     * @param \CertUnlp\NgenBundle\Entity\IncidentType $type
     * @return Incident
     */
    public function setType(\CertUnlp\NgenBundle\Entity\IncidentType $type = null) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \CertUnlp\NgenBundle\Entity\IncidentType 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Incident
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate() {
        return $this->date;
    }

    public function __toString() {
        return $this->getSlug();
    }

    /**
     * Set reporter
     *
     * @param \CertUnlp\NgenBundle\Model\ReporterInterface $reporter
     * @return Incident
     */
    public function setReporter(ReporterInterface $reporter = null) {
        $this->reporter = $reporter;

        return $this;
    }

    /**
     * Get reporter
     *
     * @return \CertUnlp\NgenBundle\Model\ReporterInterface 
     */
    public function getReporter() {
        return $this->reporter;
    }

    /**
     * Set redmine_issue_id
     *
     * @param integer $redmineIssueId
     * @return Incident
     */
    public function setRedmineIssueId($redmineIssueId) {
        $this->redmine_issue_id = $redmineIssueId;

        return $this;
    }

    /**
     * Get redmine_issue_id
     *
     * @return integer 
     */
    public function getRedmineIssueId() {
        return $this->redmine_issue_id;
    }

    /**
     * Set redmine_issue
     *
     * @param integer $redmineIssue
     * @return Incident
     */
    public function setRedmineIssue($redmineIssue) {
        $this->redmine_issue = $redmineIssue;
        $this->setRedmineIssueId($redmineIssue->id);

        return $this;
    }

    /**
     * Get redmine_issue
     *
     * @return Issue 
     */
    public function getRedmineIssue() {
        return $this->redmine_issue;
    }

    public function close() {
        $this->setIsClosed(true);
    }

    public function open() {
        $this->setIsClosed(false);
    }

    /**
     * Set evidence_file
     *
     * @param string $evidenceFile
     * @return Incident
     */
    public function setEvidenceFile(File $evidenceFile = null) {
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
     * Get evidence_file
     *
     * @return string 
     */
    public function getEvidenceFile() {
        return $this->evidence_file;
    }

    /**
     * Set evidence_file_path
     *
     * @param string $evidenceFilePath
     * @return Incident
     */
    public function setEvidenceFilePath($evidenceFilePath) {
        $this->evidence_file_path = $evidenceFilePath;

        return $this;
    }

    /**
     * Get evidence_file_path
     *
     * @return string 
     */
    public function getEvidenceFilePath($fullPath = false) {
        if ($fullPath) {
            return $this->getEvidenceSubDirectory() . "/" . $this . '.' . $this->evidence_file_path;
        }
        return $this->evidence_file_path ? $this . '.' . $this->evidence_file_path : $this->evidence_file_path;
    }

    /**
     * Get evidence_file_path
     *
     * @return string 
     */
    public function getEvidenceSubDirectory() {
        return '/' . $this->getDate()->format('Y') . '/' . $this->getDate()->format('F') . '/' . $this->getDate()->format('d');
    }

    /**
     * Set evidence_file_temp
     *
     * @param string $evidenceFileTemp
     * @return Incident
     */
    public function setEvidenceFileTemp($evidenceFileTemp) {
        $this->evidence_file_temp = $evidenceFileTemp;

        return $this;
    }

    /**
     * Get evidence_file_temp
     *
     * @return string 
     */
    public function getEvidenceFileTemp() {
        return $this->evidence_file_temp;
    }

    /**
     * Set state
     *
     * @param \CertUnlp\NgenBundle\Entity\IncidentState $state
     * @return Incident
     */
    public function setState(\CertUnlp\NgenBundle\Entity\IncidentState $state = null) {
        if (!in_array($state->getSlug(), ['open', 'stand_by'])) {
            $this->close();
        } else {
            $this->open();
        }
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \CertUnlp\NgenBundle\Entity\IncidentState 
     */
    public function getState() {
        return $this->state;
    }

    public function getOpenDays($lastTimeDetected = false) {
        if ($lastTimeDetected) {
            $date = $this->getLastTimeDetected() ? $this->getLastTimeDetected() : $this->getDate();
        } else {
            $date = $this->getDate();
        }
        $diff = $date->diff(new \DateTime());
        return $diff->days;
    }

    /**
     * Set report_sent
     *
     * @param boolean $sendReport
     * @return Incident
     */
    public function setSendReport($sendReport) {
        $this->sendReport = $sendReport;

        return $this;
    }

    /**
     * Get sendReport
     *
     * @return boolean 
     */
    public function getSendReport() {
        return $this->sendReport;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Incident
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set feed
     *
     * @param \CertUnlp\NgenBundle\Entity\IncidentFeed $feed
     * @return Incident
     */
    public function setFeed(\CertUnlp\NgenBundle\Entity\IncidentFeed $feed = null) {
        $this->feed = $feed;

        return $this;
    }

    /**
     * Get feed
     *
     * @return \CertUnlp\NgenBundle\Entity\IncidentFeed 
     */
    public function getFeed() {
        return $this->feed;
    }

    /**
     * Get evidence_file
     *
     * @return string 
     */
    public function getReportEdit() {
        return $this->report_edit;
    }

    /**
     * Get evidence_file
     *
     * @return string 
     */
    public function setReportEdit($report_edit) {
        $this->report_edit = $report_edit;
        return $this;
    }

    /**
     * Set lastTimeDetected
     *
     * @param \DateTime $lastTimeDetected
     * @return Incident
     */
    public function setLastTimeDetected($lastTimeDetected) {
        $this->lastTimeDetected = $lastTimeDetected;

        return $this;
    }

    /**
     * Get lastTimeDetected
     *
     * @return \DateTime 
     */
    public function getLastTimeDetected() {
        return $this->lastTimeDetected;
    }

    /**
     * Set renotificationDate
     *
     * @param \DateTime $renotificationDate
     * @return Incident
     */
    public function setRenotificationDate($renotificationDate) {
        $this->renotificationDate = $renotificationDate;

        return $this;
    }

    /**
     * Get renotificationDate
     *
     * @return \DateTime 
     */
    public function getRenotificationDate() {
        return $this->renotificationDate;
    }

    /**
     * Set networkAdmin
     *
     * @param \CertUnlp\NgenBundle\Entity\NetworkAdmin $networkAdmin
     * @return Incident
     */
    public function setNetworkAdmin(\CertUnlp\NgenBundle\Entity\NetworkAdmin $networkAdmin = null) {
        $this->networkAdmin = $networkAdmin;

        return $this;
    }

    /**
     * Get networkAdmin
     *
     * @return \CertUnlp\NgenBundle\Entity\NetworkAdmin 
     */
    public function getNetworkAdmin() {
        return $this->networkAdmin;
    }

    /**
     * Set report_message_id
     *
     * @param string $reportMessageId
     * @return Incident
     */
    public function setReportMessageId($reportMessageId) {
        $this->report_message_id = $reportMessageId;

        return $this;
    }

    /**
     * Get report_message_id
     *
     * @return string 
     */
    public function getReportMessageId() {
        return $this->report_message_id;
    }

    /**
     * Set comment_thread
     *
     * @param \CertUnlp\NgenBundle\Entity\IncidentCommentThread $commentThread
     * @return Incident
     */
    public function setCommentThread(\CertUnlp\NgenBundle\Entity\IncidentCommentThread $commentThread = null) {
        $this->comment_thread = $commentThread;

        return $this;
    }

    /**
     * Get comment_thread
     *
     * @return \CertUnlp\NgenBundle\Entity\IncidentCommentThread 
     */
    public function getCommentThread() {
        return $this->comment_thread;
    }

    /**
     * Set academicUnit
     *
     * @param \CertUnlp\NgenBundle\Entity\AcademicUnit $academicUnit
     * @return Incident
     */
    public function setAcademicUnit(\CertUnlp\NgenBundle\Entity\AcademicUnit $academicUnit = null) {
        $this->academicUnit = $academicUnit;

        return $this;
    }

    /**
     * Get academicUnit
     *
     * @return \CertUnlp\NgenBundle\Entity\AcademicUnit 
     */
    public function getAcademicUnit() {
        return $this->academicUnit;
    }

}
