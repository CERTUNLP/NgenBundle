<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use CertUnlp\NgenBundle\Entity\Communication\CommunicationBehavior;
use Doctrine\Common\Collections\Collection;

/**
 * IncidentDetected
 *
 * @ORM\Table(name="incident_detected")
 * @ORM\Entity
 * @ORM\EntityListeners({ "CertUnlp\NgenBundle\Entity\Incident\Listener\IncidentDetectedListener" })
 * @JMS\ExclusionPolicy("all")
 */
class IncidentDetected
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var Incident
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident", inversedBy="incidentsDetected")
     *
     * */
    protected $incident;
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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
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
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $priority;
    /**
     * @Assert\File(maxSize = "500k")
     */
    protected $evidence_file;
    /**
     * @ORM\Column(name="evidence_file_path", type="string",nullable=true)
     */
    protected $evidence_file_path;
    /**
     * @var $evidence_file_temp
     */
    protected $evidence_file_temp;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $notes;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime",nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    private $date;

    /**
     * @var Collection
     * @JMS\Expose
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentCommunication",mappedBy="ltd")
     * @JMS\Groups({"api"})
     */
     private $communicationHistory;

    /**
     * @var CommunicationBehavior
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Communication\CommunicationBehavior")
     * @ORM\JoinColumn(name="communication_behavior", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $communicationBehavior;

    public function __construct(Incident $incident, Incident $incidentFather)
    {
        $this->setIncident($incidentFather);
        $this->setFeed($incident->getFeed());
        $this->setType($incident->getType());
        $this->setAssigned($incident->getAssigned());
        $this->setDate(new DateTime('now'));
        $this->setEvidenceFile($incident->getTemporalEvidenceFile());
        $this->setEvidenceFileTemp($incident->getEvidenceFileTemp());
        if ($incident->getEvidenceFilePath() && $incident->getEvidenceFile()) {
            $this->setEvidenceFilePath($incidentFather->getEvidenceSubDirectory() . $incident->getEvidenceFilePath());
        }
        $this->setNotes($incident->getTemporalNotes());
        $this->setReporter($incident->getReporter());
        $this->setState($incident->getState());
        $this->setTlp($incident->getTlp());
        $this->setPriority($incident->getPriority());

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->getDate()->format('Y-m-d h:i') . ' - ' . $this->getFeed()->getSlug();
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return IncidentFeed
     */
    public function getFeed(): IncidentFeed
    {
        return $this->feed;
    }

    /**
     * @param IncidentFeed $feed
     */
    public function setFeed(IncidentFeed $feed): void
    {
        $this->feed = $feed;
    }

    /**
     * @return Incident
     */

    public function getIncident()
    {
        return $this->incident;
    }

    /**
     * @param Incident $incident
     */
    public function setIncident($incident)
    {
        $this->incident = $incident;
    }

    public function getCountDaysFromDetection()
    {
        $dStart = new DateTime('now');
        $dDiff = $dStart->diff($this->getDate());
        return $dDiff->days;
    }

    /**
     * @return mixed
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @param mixed $reporter
     */
    public function setReporter($reporter): void
    {
        $this->reporter = $reporter;
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
     */
    public function setAssigned(User $assigned = null): void
    {
        $this->assigned = $assigned;
    }

    /**
     * @return IncidentType
     */
    public function getType(): IncidentType
    {
        return $this->type;
    }

    /**
     * @param IncidentType $type
     *
     */
    public function setType(IncidentType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return IncidentState
     */
    public function getState(): ?IncidentState
    {
        return $this->state;
    }

    /**
     * @param IncidentState $state
     */
    public function setState(IncidentState $state): void
    {
        $this->state = $state;
    }

    /**
     * @return IncidentTlp
     */
    public function getTlp(): IncidentTlp
    {
        return $this->tlp;
    }

    /**
     * @param IncidentTlp $tlp
     */
    public function setTlp(IncidentTlp $tlp): void
    {
        $this->tlp = $tlp;
    }

    /**
     * @return IncidentPriority
     */
    public function getPriority(): IncidentPriority
    {
        return $this->priority;
    }

    /**
     * @param IncidentPriority $priority
     */

    public function setPriority(IncidentPriority $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return mixed
     */
    public function getEvidenceFile()
    {
        return $this->evidence_file;
    }

    /**
     * @param mixed $evidence_file
     */
    public function setEvidenceFile($evidence_file): void
    {
        $this->evidence_file = $evidence_file;
    }

    /**
     * @return mixed
     */
    public function getEvidenceFilePath()
    {
        return $this->evidence_file_path;
    }

    /**
     * @param mixed $evidence_file_path
     */
    public function setEvidenceFilePath($evidence_file_path): void
    {

        $this->evidence_file_path = $evidence_file_path;
    }

    /**
     * @return mixed
     */
    public function getEvidenceFileTemp()
    {
        return $this->evidence_file_temp;
    }

    /**
     * @param mixed $evidence_file_temp
     */
    public function setEvidenceFileTemp($evidence_file_temp): void
    {
        $this->evidence_file_temp = $evidence_file_temp;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return Collection
     */
    public function getCommunicationHistory(): Collection
    {
        return $this->communicationHistory;
    }

    /**
     * @param Collection $communicationHistory
     */
    public function setCommunicationHistory(Collection $communicationHistory): void
    {
        $this->communicationHistory = $communicationHistory;
    }

    /**
     * @return CommunicationBehavior
     */
    public function getCommunicationBehavior(): CommunicationBehavior
    {
        return $this->communicationBehavior;
    }

    /**
     * @param CommunicationBehavior $communicationBehavior
     */
    public function setCommunicationBehavior(CommunicationBehavior $communicationBehavior): void
    {
        $this->communicationBehavior = $communicationBehavior;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes): void
    {
        $this->notes = $notes;
    }


}