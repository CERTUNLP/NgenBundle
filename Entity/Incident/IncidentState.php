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
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * Description of IncidentClosingType
 *
 * @author dam
 * @ORM\Table()
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class IncidentState
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @JMS\Expose
     * @JMS\Groups({"api_input"})
     */
    private $name;

    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100)
     * @JMS\Expose
     * @JMS\Groups({"api_input"})
     * */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;

    /**
     * @var ContactCase
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_assigned", referencedColumnName="slug")
     */
    private $mailAssigned;


    /**
     * @var ContactCase
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_team", referencedColumnName="slug")
     */

    private $mailTeam;

    /**
     * @var ContactCase
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_admin", referencedColumnName="slug")
     */

    private $mailAdmin;


    /**
     * @var ContactCase
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase")
     * @ORM\JoinColumn(name="mail_reporter", referencedColumnName="slug")
     */

    private $mailReporter;
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="state")) */

    private $incidents;

    /**
     * @var IncidentStateAction
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentStateAction", inversedBy="incident_state")
     * @ORM\JoinColumn(name="incident_state_action", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $incident_action;

    /**
     * @return IncidentStateAction
     */
    public function getIncidentAction(): IncidentStateAction
    {
        return $this->incident_action;
    }

    /**
     * @param IncidentStateAction $incident_action
     */
    public function setIncidentAction(IncidentStateAction $incident_action): void
    {
        $this->incident_action = $incident_action;
    }

    /**
     * @return bool
     */
    public function isOpening(): bool
    {
        return $this->getIncidentAction()->isOpen();
    }


    /**
     * @return bool
     */
    public function isClosing(): bool
    {
       return $this->getIncidentAction()->isClose();
    }

    /**
     * @return bool
     */
    public function isReOpening(): bool
    {
        return $this->getIncidentAction()->isReOpen();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->incidents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return ContactCase
     */
    public function getMailAssigned()
    {
        return $this->mailAssigned;
    }

    /**
     * @param ContactCase $mailAssigned
     */
    public function setMailAssigned($mailAssigned)
    {
        $this->mailAssigned = $mailAssigned;
    }

    /**
     * @return ContactCase
     */
    public function getMailTeam()
    {
        return $this->mailTeam;
    }

    /**
     * @param ContactCase $mailTeam
     */
    public function setMailTeam($mailTeam)
    {
        $this->mailTeam = $mailTeam;
    }

    /**
     * @return ContactCase
     */
    public function getMailAdmin()
    {
        return $this->mailAdmin;
    }

    /**
     * @param ContactCase $mailAdmin
     */
    public function setMailAdmin($mailAdmin)
    {
        $this->mailAdmin = $mailAdmin;
    }

    /**
     * @return ContactCase
     */
    public function getMailReporter()
    {
        return $this->mailReporter;
    }

    /**
     * @param ContactCase $mailReporter
     */
    public function setMailReporter($mailReporter)
    {
        $this->mailReporter = $mailReporter;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return IncidentState
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->getSlug();
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return IncidentState
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return IncidentState
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return IncidentState
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return IncidentState
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Add incident
     *
     * @param Incident $incident
     *
     * @return IncidentState
     */
    public function addIncident(Incident $incident)
    {
        $this->incidents[] = $incident;

        return $this;
    }

    /**
     * Remove incident
     *
     * @param Incident $incident
     */
    public function removeIncident(Incident $incident)
    {
        $this->incidents->removeElement($incident);
    }

    /**
     * Get incidents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIncidents()
    {
        return $this->incidents;
    }

    public function getContacts(int $incidentPriority, bool $force): array
    {
        $contactos = [];
        if ($this->notificar_admin($incidentPriority))
            if ($force) {
                return $contactos;
            }
    }
}
