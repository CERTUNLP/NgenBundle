<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\EntityApiFrontend;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * IncidentDetected
 *
 * @ORM\Entity()
 * @ORM\EntityListeners({"CertUnlp\NgenBundle\Service\Listener\Entity\IncidentDetectedListener"})
 * @JMS\ExclusionPolicy("all")
 */
class IncidentDetected extends EntityApiFrontend
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
     */
    private $incident;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User")
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $reporter;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User", inversedBy="assignedIncidents")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $assigned;
    /**
     * @var IncidentType
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType",inversedBy="incidents")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $type;
    /**
     * @var IncidentFeed
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentFeed", inversedBy="incidents")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     * @Assert\NotNull
     */
    private $feed;
    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $state;
    /**
     * @var IncidentTlp
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentTlp", inversedBy="incidents")
     * @ORM\JoinColumn(name="tlp_state", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $tlp;
    /**
     * @var IncidentPriority
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentPriority", inversedBy="incidents")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $priority;
    /**
     * @Assert\File(maxSize = "5M")
     */
    private $evidence_file;
    /**
     * @ORM\Column(name="evidence_file_path", type="string",nullable=true)
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $evidence_file_path;
    /**
     * @var $evidence_file_temp
     */
    private $evidence_file_temp;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $notes;
    /**
     * @var DateTime
     * @ORM\Column(name="date", type="datetime",nullable=true)
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $date;

    public function __construct(Incident $incident, Incident $incidentFather)
    {
        $this->setIncident($incidentFather);
        $this->setFeed($incident->getFeed());
        $this->setType($incident->getType());
        $this->setAssigned($incident->getAssigned());
        $this->setDate(new DateTime('now'));
        $this->setEvidenceFile($incident->getEvidenceFile());
        if ($incident->getEvidenceFilePath() && $incident->getEvidenceFile()) {
            $this->setEvidenceFilePath($incidentFather->getEvidenceSubDirectory() . $incident->getEvidenceFilePath());
        }
        $this->setNotes($incident->getNotes());
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

    public function getIncident(): Incident
    {
        return $this->incident;
    }

    /**
     * @param Incident $incident
     * @return IncidentDetected
     */
    public function setIncident(Incident $incident): IncidentDetected
    {
        $this->incident = $incident;
        return $this;
    }

    /**
     * @return User
     */
    public function getReporter(): User
    {
        return $this->reporter;
    }

    /**
     * @param User $reporter
     */
    public function setReporter(User $reporter): void
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
     * @return UploadedFile
     */
    public function getEvidenceFile(): UploadedFile
    {
        return $this->evidence_file;
    }

    /**
     * @param UploadedFile|null $evidence_file
     * @return IncidentDetected
     */
    public function setEvidenceFile(UploadedFile $evidence_file = null): IncidentDetected
    {
        $this->evidence_file = $evidence_file;
        return $this;
    }

    /**
     * @return string
     */
    public function getEvidenceFilePath(): ?string
    {
        return $this->evidence_file_path;
    }

    /**
     * @param string $evidence_file_path
     */
    public function setEvidenceFilePath(string $evidence_file_path): void
    {
        $this->evidence_file_path = $evidence_file_path;
    }

    /**
     * @return string
     */
    public function getEvidenceFileTemp(): string
    {
        return $this->evidence_file_temp;
    }

    /**
     * @param string|null $evidence_file_temp
     * @return IncidentDetected
     */
    public function setEvidenceFileTemp(string $evidence_file_temp = null): IncidentDetected
    {
        $this->evidence_file_temp = $evidence_file_temp;
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
     * @param string|null $notes
     * @return IncidentDetected
     */
    public function setNotes(string $notes = null): IncidentDetected
    {
        $this->notes = $notes;
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
     * {@inheritDoc}
     */
    public function getDataIdentificationArray(): array
    {
        return [];
    }
}