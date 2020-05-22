<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident\State\Edge;

use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactCase;
use CertUnlp\NgenBundle\Entity\EntityApi;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;


/**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"new"= "NewEdge", "opening" = "OpeningEdge", "closing" = "ClosingEdge", "reopening" = "ReopeningEdge", "updating" = "UpdatingEdge", "discarding" = "DiscardingEdge", "edge" = "StateEdge"})
 * @JMS\ExclusionPolicy("all")
 */
abstract class StateEdge extends EntityApi
{
    /**
     * @var integer|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    protected $id;
    /**
     * @var IncidentState|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState", inversedBy="edges")
     * @ORM\JoinColumn(name="oldState", referencedColumnName="slug")
     * @JMS\Expose
     */
    private $oldState;
    /**
     * @var IncidentState|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="newState", referencedColumnName="slug")
     * @JMS\Expose
     */
    private $newState;
    /**
     * @var ContactCase|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Communication\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_assigned", referencedColumnName="slug")
     */
    private $mailAssigned;
    /**
     * @var ContactCase|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Communication\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_team", referencedColumnName="slug")
     */
    private $mailTeam;
    /**
     * @var ContactCase|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Communication\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_admin", referencedColumnName="slug")
     */
    private $mailAdmin;
    /**
     * @var ContactCase|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Communication\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_reporter", referencedColumnName="slug")
     */
    private $mailReporter;

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'long-arrow-alt-right1';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->getNewState()->getColor();
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
     * @return StateEdge
     */
    public function setNewState(IncidentState $newState): StateEdge
    {
        $this->newState = $newState;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentificatorString(): string
    {
        return 'id';
    }

    public function __toString(): string
    {
        return (string)str_replace('\\', '', explode('Edge', get_class($this))[1]);
    }

    /**
     * @return ContactCase
     */
    public function getMailAssigned(): ContactCase
    {
        return $this->mailAssigned;
    }

    /**
     * @param ContactCase $mailAssigned
     * @return StateEdge
     */
    public function setMailAssigned(ContactCase $mailAssigned): StateEdge
    {
        $this->mailAssigned = $mailAssigned;
        return $this;
    }

    /**
     * @return ContactCase
     */
    public function getMailTeam(): ContactCase
    {
        return $this->mailTeam;
    }

    /**
     * @param ContactCase $mailTeam
     * @return StateEdge
     */
    public function setMailTeam(ContactCase $mailTeam): StateEdge
    {
        $this->mailTeam = $mailTeam;
        return $this;
    }

    /**
     * @return ContactCase
     */
    public function getMailAdmin(): ContactCase
    {
        return $this->mailAdmin;
    }

    /**
     * @param ContactCase $mailAdmin
     * @return StateEdge
     */
    public function setMailAdmin(ContactCase $mailAdmin): StateEdge
    {
        $this->mailAdmin = $mailAdmin;
        return $this;
    }

    /**
     * @return ContactCase
     */
    public function getMailReporter(): ContactCase
    {
        return $this->mailReporter;
    }

    /**
     * @param ContactCase $mailReporter
     * @return StateEdge
     */
    public function setMailReporter(ContactCase $mailReporter): StateEdge
    {
        $this->mailReporter = $mailReporter;
        return $this;
    }

    /**
     * @param Incident $incident
     * @return Incident
     */
    public function changeState(Incident $incident): Incident
    {
        $this->changeStateAction($incident);
        $incident->changeState($this->getNewState());
        return $incident;

    }

    abstract public function changeStateAction(Incident $incident): Incident;

    /**
     * @return IncidentState
     */
    public function getOldState(): IncidentState
    {
        return $this->oldState;
    }

    /**
     * @param IncidentState $oldState
     * @return StateEdge
     */
    public function setOldState(IncidentState $oldState): StateEdge
    {
        $this->oldState = $oldState;
        return $this;
    }


}
