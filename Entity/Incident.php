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
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 * @JMS\ExclusionPolicy("all")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"incident"="incident","internal" = "InternalIncident", "external" = "ExternalIncident"})
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
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Model\ReporterInterface", inversedBy="incidents") 
     */
    protected $reporter;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_closed", type="boolean")
     * @JMS\Expose
     * @JMS\Type("boolean")
     */
    protected $isClosed = false;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentType")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentFeed") 
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $feed;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentState") 
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $state;

    /**
     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentCommentThread",mappedBy="incident",fetch="EXTRA_LAZY"))
     */
    private $comment_thread;

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
     * Set network
     *
     * @param \CertUnlp\NgenBundle\Model\NetworkInterface $network
     * @return Incident
     */
    public function setNetwork(NetworkInterface $network = null) {
        
    }

    /**
     * Get network
     *
     * @return \CertUnlp\NgenBundle\Model\NetworkInterface
     */
    public function getNetwork() {
        
    }

    /**
     * Set commentThread
     *
     * @param \CertUnlp\NgenBundle\Entity\IncidentCommentThread $commentThread
     *
     * @return Incident
     */
    public function setCommentThread(\CertUnlp\NgenBundle\Entity\IncidentCommentThread $commentThread = null) {
        $this->comment_thread = $commentThread;

        return $this;
    }

    /**
     * Get commentThread
     *
     * @return \CertUnlp\NgenBundle\Entity\IncidentCommentThread
     */
    public function getCommentThread() {
        return $this->comment_thread;
    }

    public function getEmails() {
        return [];
    }

}
