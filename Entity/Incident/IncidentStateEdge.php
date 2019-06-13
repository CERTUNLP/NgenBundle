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

use DateTime;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState", inversedBy="edgesAsOldState")
     * @ORM\JoinColumn(name="oldState", referencedColumnName="slug")
     */
    protected $oldState;

    /**
     * @var IncidentState
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState", inversedBy="edgesAsNewState")
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return IncidentStateEdge
     */
    public function setId(int $id): IncidentStateEdge
    {
        $this->id = $id;
        return $this;
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
     * @return IncidentStateEdge
     */
    public function setOldState(IncidentState $oldState): IncidentStateEdge
    {
        $this->oldState = $oldState;
        return $this;
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
     * @return IncidentStateEdge
     */
    public function setNewState(IncidentState $newState): IncidentStateEdge
    {
        $this->newState = $newState;
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
     * @return IncidentStateEdge
     */
    public function setIsActive(bool $isActive): IncidentStateEdge
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
     * @return IncidentStateEdge
     */
    public function setCreatedAt(?DateTime $createdAt): IncidentStateEdge
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
     * @return IncidentStateEdge
     */
    public function setUpdatedAt(?DateTime $updatedAt): IncidentStateEdge
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


}
