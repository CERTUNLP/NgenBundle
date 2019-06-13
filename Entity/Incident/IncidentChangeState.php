<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

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

    public function __construct(Incident $incident,IncidentState $newState,$responsable, IncidentState $oldState=null, $method = "frontend" )
    {
        $this->setIncident($incident);
        if ($oldState){$this->setOldState($oldState);}
        $this->setNewState($newState);
        $this->setDate(new DateTime('now'));
        $this->setMethod($method);
        $this->setResponsable($responsable);
        $this->setActionApplied($newState->getIncidentStatebehavior());
    }

    /**
     * @var Incident
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident", inversedBy="changeStateHistory")
     *
     * */
    protected $incident;

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
        return $this->newState;
    }

    /**
     * @param IncidentState $newState
     */
    public function setNewState(IncidentState $newState): void
    {
        $this->newState = $newState;
    }

    /**
     * @return IncidentState
     */
    public function getOldState(): ? IncidentState
    {
        return $this->oldState;
    }

    /**
     * @param IncidentState $oldState
     */
    public function setOldState(IncidentState $oldState): void
    {
        $this->oldState = $oldState;
    }

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
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState")
     * @ORM\JoinColumn(name="newState", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $newState;
    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState")
     * @ORM\JoinColumn(name="oldState", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $oldState;

    /**
     * @var IncidentStateBehavior
     * @ORM\ManyToOne(targetEntity="IncidentStateBehavior")
     * @ORM\JoinColumn(name="action_applied", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $actionApplied;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User")
     */
    protected $responsable;

    /**
     * @return IncidentStateBehavior
     */
    public function getActionApplied(): ? IncidentStateBehavior
    {
        return $this->actionApplied;
    }

    /**
     * @param IncidentStateBehavior $actionApplied
     */
    public function setActionApplied(IncidentStateBehavior $actionApplied): void
    {
        $this->actionApplied = $actionApplied;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", length=25)
     * @JMS\Expose
     * @JMS\Groups({"api_input"})
     */
    protected $method;

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