<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\Incident\State\Edge\StateEdge;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 *
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class IncidentStateChange extends Entity
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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident", inversedBy="state_changes")
     */
    private $incident;
    /**
     * @var StateEdge
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\Edge\StateEdge")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $stateEdge;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User")}
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $responsable;
    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", length=25)
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $method;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime",nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $date;

    public function __construct(Incident $incident, StateEdge $stateEdge, User $responsable = null, string $method = 'frontend')
    {
        $this->setIncident($incident);
        if (!$responsable) {
            if ($incident->getReporter()) {
                $responsable = $incident->getReporter();
            } else {
                $responsable = $incident->getReportReporter();
            }
        }
        $this->setStateEdge($stateEdge);
        $this->setDate(new DateTime('now'));
        $this->setMethod($method);
        $this->setResponsable($responsable);
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
     * @return IncidentStateChange
     */
    public function setId(int $id): IncidentStateChange
    {
        $this->id = $id;
        return $this;
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
     */
    public function setIncident(Incident $incident): void
    {
        $this->incident = $incident;
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
     * @return IncidentState
     * @JMS\Expose()
     * @JMS\VirtualProperty()
     * @JMS\Groups({"read","write"})
     */
    public function getNewState(): IncidentState
    {
        return $this->getStateEdge()->getNewState();
    }

    /**
     * @return StateEdge
     */
    public function getStateEdge(): ?StateEdge
    {
        return $this->stateEdge;
    }

    /**
     * @param StateEdge $stateEdge
     * @return IncidentStateChange
     */
    public function setStateEdge(StateEdge $stateEdge): IncidentStateChange
    {
        $this->stateEdge = $stateEdge;
        return $this;
    }

    /**
     * @return IncidentState
     * @JMS\Expose()
     * @JMS\VirtualProperty()
     * @JMS\Groups({"read","write"})
     */
    public function getOldState(): ?IncidentState
    {
        return $this->getStateEdge()->getOldState();
    }


    /**
     * @return StateEdge
     */
    public function getActionApplied(): ?StateEdge
    {
        return $this->getStateEdge();
    }


    /**
     * @return User
     */
    public function getResponsable(): ?User
    {
        return $this->responsable;
    }

    /**
     * @param User $responsable
     */
    public function setResponsable(User $responsable): void
    {
        $this->responsable = $responsable;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }
}