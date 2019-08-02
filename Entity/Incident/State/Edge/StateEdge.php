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

use CertUnlp\NgenBundle\Entity\Contact\ContactCase;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;


/**
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"opening" = "OpeningEdge", "closing" = "ClosingEdge", "reopening" = "ReopeningEdge", "updating" = "UpdatingEdge", "discarding" = "DiscardingEdge", "edge" = "StateEdge"})
 * @JMS\ExclusionPolicy("all")
 */
abstract class StateEdge
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
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState", inversedBy="edges")
     * @ORM\JoinColumn(name="oldState", referencedColumnName="slug")
     * @JMS\Expose
     */
    protected $oldState;

    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\State\IncidentState")
     * @ORM\JoinColumn(name="newState", referencedColumnName="slug")
     * @JMS\Expose
     */
    protected $newState;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;

    /**
     * @var DateTime|null
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;
    /**
     * @var DateTime|null
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;
    /**
     * @var ContactCase|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_assigned", referencedColumnName="slug")
     */
    private $mailAssigned;

    /**
     * @var ContactCase|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_team", referencedColumnName="slug")
     */

    private $mailTeam;

    /**
     * @var ContactCase|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_admin", referencedColumnName="slug")
     */
    private $mailAdmin;

    /**
     * @var ContactCase|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_reporter", referencedColumnName="slug")
     */
    private $mailReporter;

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
     * @throws Exception
     */
    public function changeIncidentState(Incident $incident): Incident
    {
        $this->changeIncidentStateAction($incident);
        $incident->changeState($this->getNewState());
        return $incident;

    }

    abstract public function changeIncidentStateAction(Incident $incident): Incident;

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
     * @return bool
     */
    public function isOpening(): bool
    {
        return $this->isNewToOpen();
    }

    /**
     * @return bool
     */
    public function isNewToOpen(): bool
    {

        return $this->getOldState()->isNew() && $this->getNewState()->isOpen();
    }

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

    /**
     * @return bool
     */
    public function isClosing(): bool
    {

        return $this->isOpenToClose() || $this->isNewToClose();
    }

    /**
     * @return bool
     */
    public function isOpenToClose(): bool
    {
        return $this->getOldState()->isOpen() && $this->getNewState()->isClosed();
    }

    /**
     * @return bool
     */
    public function isNewToClose(): bool
    {

        return $this->getOldState()->isNew() && $this->getNewState()->isClosed();
    }

    /**
     * @return bool
     */
    public function isReopening(): bool
    {
        return $this->isCloseToOpen();
    }

    /**
     * @return bool
     */
    public function isCloseToOpen(): bool
    {

        return $this->getOldState()->isClosed() && $this->getNewState()->isOpen();
    }

    /**
     * @return bool
     */
    public function isUpdating(): bool
    {
        return $this->isOpenToOpen() || $this->isCloseToClose() || $this->isNewToNew();
    }

    /**
     * @return bool
     */
    public function isOpenToOpen(): bool
    {

        return $this->getOldState()->isOpen() && $this->getNewState()->isOpen();
    }

    /**
     * @return bool
     */
    public function isCloseToClose(): bool
    {

        return $this->getOldState()->isOpen() && $this->getNewState()->isOpen();
    }

    /**
     * @return bool
     */
    public function isNewToNew(): bool
    {

        return $this->getOldState()->isNew() && $this->getNewState()->isNew();
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
     * @return StateEdge
     */
    public function setId(int $id): StateEdge
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return StateEdge
     */
    public function setIsActive(bool $isActive): StateEdge
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return StateEdge
     */
    public function setCreatedAt(?DateTime $createdAt): StateEdge
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return StateEdge
     */
    public function setUpdatedAt(?DateTime $updatedAt): StateEdge
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}
