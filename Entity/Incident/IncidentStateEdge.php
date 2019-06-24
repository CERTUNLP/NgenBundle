<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Contact\ContactCase;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

//use Doctrine\Common\Collections\Collection;

/**
 * IncidentType
 *
 * @ORM\Entity()
 * @JMS\ExclusionPolicy("all")
 */
class IncidentStateEdge
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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState", inversedBy="edges")
     * @ORM\JoinColumn(name="oldState", referencedColumnName="slug")
     */
    protected $oldState;

    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState")
     * @ORM\JoinColumn(name="newState", referencedColumnName="slug")
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

    /**
     * @return ContactCase
     */
    public function getMailAssigned(): ContactCase
    {
        return $this->mailAssigned;
    }

    /**
     * @param ContactCase $mailAssigned
     * @return IncidentStateEdge
     */
    public function setMailAssigned(ContactCase $mailAssigned): IncidentStateEdge
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
     * @return IncidentStateEdge
     */
    public function setMailTeam(ContactCase $mailTeam): IncidentStateEdge
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
     * @return IncidentStateEdge
     */
    public function setMailAdmin(ContactCase $mailAdmin): IncidentStateEdge
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
     * @return IncidentStateEdge
     */
    public function setMailReporter(ContactCase $mailReporter): IncidentStateEdge
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
        if ($this->isOpening()) {
            $incident->setNeedToCommunicate(true);
            $incident->setOpenedAt(new DateTime('now'));
        }
        if ($this->isClosing()) {
        }
        if ($this->isReopening()) {
            $incident->setNeedToCommunicate(true);
        }

        if ($this->isUpdating()) {

        }
        return $incident;

    }


    /**
     * @return bool
     */
    public
    function isOpening(): bool
    {
        return $this->isNewToOpen();
    }

    /**
     * @return bool
     */
    public
    function isNewToOpen(): bool
    {

        return $this->getOldState()->isNew() && $this->getOldState()->isOpen();
    }

    /**
     * @return IncidentState
     */
    public
    function getOldState(): IncidentState
    {
        return $this->oldState;
    }

    /**
     * @param IncidentState $oldState
     * @return IncidentStateEdge
     */
    public
    function setOldState(IncidentState $oldState): IncidentStateEdge
    {
        $this->oldState = $oldState;
        return $this;
    }

    /**
     * @return bool
     */
    public
    function isClosing(): bool
    {

        return $this->isOpenToClose() || $this->isNewToClose();
    }

    /**
     * @return bool
     */
    public
    function isOpenToClose(): bool
    {

        return $this->getOldState()->isOpen() || $this->getOldState()->isClosed();
    }

    /**
     * @return bool
     */
    public
    function isNewToClose(): bool
    {

        return $this->getOldState()->isNew() && $this->getOldState()->isClosed();
    }

    /**
     * @return bool
     */
    public
    function isReopening(): bool
    {
        return $this->isCloseToOpen();
    }

    /**
     * @return bool
     */
    public
    function isCloseToOpen(): bool
    {

        return $this->getOldState()->isClosed() && $this->getOldState()->isOpen();
    }

    /**
     * @return bool
     */
    public
    function isUpdating(): bool
    {
        return $this->isOpenToOpen() || $this->isCloseToClose() || $this->isNewToNew();
    }

    /**
     * @return bool
     */
    public
    function isOpenToOpen(): bool
    {

        return $this->getOldState()->isOpen() && $this->getOldState()->isOpen();
    }

    /**
     * @return bool
     */
    public
    function isCloseToClose(): bool
    {

        return $this->getOldState()->isOpen() && $this->getOldState()->isOpen();
    }

    /**
     * @return bool
     */
    public
    function isNewToNew(): bool
    {

        return $this->getOldState()->isNew() && $this->getOldState()->isNew();
    }

    /**
     * @return int
     */
    public
    function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return IncidentStateEdge
     */
    public
    function setId(int $id): IncidentStateEdge
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return IncidentState
     */
    public
    function getNewState(): IncidentState
    {
        return $this->newState;
    }

    /**
     * @param IncidentState $newState
     * @return IncidentStateEdge
     */
    public
    function setNewState(IncidentState $newState): IncidentStateEdge
    {
        $this->newState = $newState;
        return $this;
    }

    /**
     * @return bool
     */
    public
    function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return IncidentStateEdge
     */
    public
    function setIsActive(bool $isActive): IncidentStateEdge
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public
    function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return IncidentStateEdge
     */
    public
    function setCreatedAt(?DateTime $createdAt): IncidentStateEdge
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public
    function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return IncidentStateEdge
     */
    public
    function setUpdatedAt(?DateTime $updatedAt): IncidentStateEdge
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}
