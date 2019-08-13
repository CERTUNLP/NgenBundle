<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Incident\State\Edge\StateEdge;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentStateBehavior;
use CertUnlp\NgenBundle\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * IncidentChangeState
 *
 * @ORM\Table(name="incident_change_state")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class IncidentChangeState
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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident", inversedBy="changeStateHistory")
     *
     * */
    protected $incident;
    /**
     * @var StateEdge
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\Edge\StateEdge")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $stateEdge;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User")}
     * @JMS\Expose
     */
    protected $responsable;
    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", length=25)
     * @JMS\Expose
     * @JMS\Groups({"api_input"})
     */
    protected $method;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime",nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
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
     * @return IncidentChangeState
     */
    public function setId(int $id): IncidentChangeState
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
     */
    public function getNewState(): IncidentState
    {
        return $this->getStateEdge()->getNewState();
    }

    /**
     * @return StateEdge
     */
    public function getStateEdge(): StateEdge
    {
        return $this->stateEdge;
    }

    /**
     * @param StateEdge $stateEdge
     * @return IncidentChangeState
     */
    public function setStateEdge(StateEdge $stateEdge): IncidentChangeState
    {
        $this->stateEdge = $stateEdge;
        return $this;
    }

    /**
     * @return IncidentState
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
    public function getResponsable(): User
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