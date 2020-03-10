<?php

namespace CertUnlp\NgenBundle\Entity\Communication\Behavior;

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")manual','file','data', 'all'
 * @ORM\DiscriminatorMap({"all"= "CommunicationBehaviorAll","manual" = "CommunicationBehaviorManual", "file" = "CommunicationBehaviorFile", "data" = "CommunicationBehaviorData", "communication" = "CommunicationBehavior"})
 * @JMS\ExclusionPolicy("all")
 */
abstract class CommunicationBehavior extends Entity implements Translatable
{

    /**
     * @var DateTime|null
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    protected $updatedAt;
    /**
     * @var string|null
     * @ORM\Id
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
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     * @JMS\Expose
     */
    private $description;
    /**
     * @var DateTime|null
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var IncidentDetected
     */
    private $incidentDetected = null;

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return CommunicationBehavior
     */
    public function setUpdatedAt(?DateTime $updatedAt): CommunicationBehavior
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return IncidentDetected
     */
    public function getIncidentDetected(): IncidentDetected
    {
        return $this->incidentDetected;
    }

    /**
     * @param IncidentDetected $incidentDetected
     * @return CommunicationBehavior
     */
    public function setIncidentDetected(IncidentDetected $incidentDetected): self
    {
        $this->incidentDetected = $incidentDetected;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
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
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'th';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'primary';
    }

    abstract public function print(): ?string;

    abstract public function getFile(): ?string;

}
