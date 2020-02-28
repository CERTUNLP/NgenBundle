<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
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

    private $communicationBehaviorNew;

    /**
     * @var CommunicationBehavior | null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Communication\CommunicationBehavior")
     * @ORM\JoinColumn(name="communication_behavior_update", referencedColumnName="slug")
     * @JMS\Expose()
     */

    private $communicationBehaviorUpdate;

    /**
     * @var CommunicationBehavior | null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Communication\CommunicationBehavior")
     * @ORM\JoinColumn(name="communication_behavior_open", referencedColumnName="slug")
     * @JMS\Expose()
     */

    private $communicationBehaviorOpen;

    /**
     * @var CommunicationBehavior | null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Communication\CommunicationBehavior")
     * @ORM\JoinColumn(name="communication_behavior_summary", referencedColumnName="slug")
     * @JMS\Expose()
     */

    private $communicationBehaviorSummary;
    /**
     * @var CommunicationBehavior | null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Communication\CommunicationBehavior")
     * @ORM\JoinColumn(name="communication_behavior_close", referencedColumnName="slug")
     * @JMS\Expose()
     */

    private $communicationBehaviorClose;

    /**
     * @var string
     *
     * @ORM\Column(name="when_to_update", type="string", length=100)
     * @JMS\Expose
     * @JMS\Groups({"api_input"})
     * @Gedmo\Translatable
     */
    private $whenToUpdate="now";

    /**
     * @var array|null
     *
     * @ORM\Column(name="intelmq_data", type="json_array")
     */
    private $intelmqData;

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
        if($incident->getIntelmqData()){
            $this->setIntelmqData($incident->getIntelmqData());
        }
        $this->setNotes($incident->getTemporalNotes());
        $this->setReporter($incident->getReporter());
        $this->setState($incident->getState());
        $this->setTlp($incident->getTlp());
        $this->setPriority($incident->getPriority());
        $this->setCommunicationBehaviorNew($incident->getCommunicationBehaviorNew());
        $this->setCommunicationBehaviorOpen($incident->getCommunicationBehaviorOpen());
        $this->setCommunicationBehaviorUpdate($incident->getCommunicationBehaviorUpdate());
        $this->setCommunicationBehaviorSummary($incident->getCommunicationBehaviorSummary());
        $this->setCommunicationBehaviorClose($incident->getCommunicationBehaviorClose());
        $this->setWhenToUpdate($incident->getWhenToUpdate());

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
     * @param mixed $notes
     */
    public function setNotes($notes): void
    {
        $this->notes = $notes;
    }

    /**
     * @return mixed
     */
    public function getCommunicationBehaviorNew()
    {
        return $this->communicationBehaviorNew;
    }

    /**
     * @param mixed $communicationBehaviorNew
     */
    public function setCommunicationBehaviorNew($communicationBehaviorNew): void
    {
        $this->communicationBehaviorNew = $communicationBehaviorNew;
    }

    /**
     * @return CommunicationBehavior|null
     */
    public function getCommunicationBehaviorUpdate(): ?CommunicationBehavior
    {
        return $this->communicationBehaviorUpdate;
    }

    /**
     * @param CommunicationBehavior|null $communicationBehaviorUpdate
     */
    public function setCommunicationBehaviorUpdate(?CommunicationBehavior $communicationBehaviorUpdate): void
    {
        $this->communicationBehaviorUpdate = $communicationBehaviorUpdate;
    }

    /**
     * @return CommunicationBehavior|null
     */
    public function getCommunicationBehaviorOpen(): ?CommunicationBehavior
    {
        return $this->communicationBehaviorOpen;
    }

    /**
     * @param CommunicationBehavior|null $communicationBehaviorOpen
     */
    public function setCommunicationBehaviorOpen(?CommunicationBehavior $communicationBehaviorOpen): void
    {
        $this->communicationBehaviorOpen = $communicationBehaviorOpen;
    }

    /**
     * @return CommunicationBehavior|null
     */
    public function getCommunicationBehaviorSummary(): ?CommunicationBehavior
    {
        return $this->communicationBehaviorSummary;
    }

    /**
     * @param CommunicationBehavior|null $communicationBehaviorSummary
     */
    public function setCommunicationBehaviorSummary(?CommunicationBehavior $communicationBehaviorSummary): void
    {
        $this->communicationBehaviorSummary = $communicationBehaviorSummary;
    }

    /**
     * @return CommunicationBehavior|null
     */
    public function getCommunicationBehaviorClose(): ?CommunicationBehavior
    {
        return $this->communicationBehaviorClose;
    }

    /**
     * @param CommunicationBehavior|null $communicationBehaviorClose
     */
    public function setCommunicationBehaviorClose(?CommunicationBehavior $communicationBehaviorClose): void
    {
        $this->communicationBehaviorClose = $communicationBehaviorClose;
    }

    /**
     * @return string
     */
    public function getWhenToUpdate(): string
    {
        return $this->whenToUpdate;
    }

    /**
     * @param string $whenToUpdate
     */
    public function setWhenToUpdate(string $whenToUpdate): void
    {
        $this->whenToUpdate = $whenToUpdate;
    }

    /**
     * @return array|null
     */
    public function getIntelmqData(): ?array
    {
        return $this->intelmqData;
    }

    /**
     * @param array|null $intelmqData
     */
    public function setIntelmqData(?array $intelmqData): void
    {
        $this->intelmqData = $intelmqData;
    }

}