<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use GuzzleHttp\Collection;
use JMS\Serializer\Annotation as JMS;

/**
 * IncidentPriority
 *
 * @ORM\Table(name="incident_priority")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IndicentPriorityRepository")
 * @JMS\ExclusionPolicy("all")
 */
class IncidentPriority implements Translatable
{
    /**
     * @var IncidentImpact|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentImpact",inversedBy="incidentsPriorities")
     * @ORM\JoinColumn(name="impact", referencedColumnName="slug")
     * @JMS\Expose
     */
    private $impact;

    /**
     * @var IncidentUrgency|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency", inversedBy="incidentsPriorities")
     * @ORM\JoinColumn(name="urgency", referencedColumnName="slug")
     * @JMS\Expose
     */
    private $urgency;

    /**
     * @var Incident[] | Collection | null
     *
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="priority"))
     * @JMS\Exclude()
     */
    private $incidents;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;
    /**
     * @var int|null
     *
     * @ORM\Column(name="unresponse_time", type="integer")
     * @JMS\Expose
     */
    private $unresponseTime;
    /**
     * @var integer|null
     * @ORM\Column(name="unresolution_time", type="integer")
     * @JMS\Expose
     */
    private $unresolutionTime;
    /**
     * @var int|null
     *
     * @ORM\Column(name="code", type="integer")
     * @JMS\Expose
     */
    private $code;

    /**
     * @var string|null
     * @ORM\Id
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @JMS\Expose
     */

    private $slug;

    /**
     * @var string|null
     * @ORM\Column(name="name", type="string", length=255)
     * @JMS\Expose
     * @Gedmo\Translatable
     */
    private $name;

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
     * @var integer|null
     * @ORM\Column(name="response_time", type="integer")
     * @JMS\Expose
     */
    private $responseTime;

    /**
     * @var integer|null
     * @ORM\Column(name="resolution_time", type="integer")
     * @JMS\Expose
     */
    private $resolutionTime;

    public function __construct()
    {
        $this->incidents = new ArrayCollection();
    }

    /**
     * @return Incident[] | Collection
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    /**
     * @param Collection $incidents
     * @return IncidentPriority
     */
    public function setIncidents(Collection $incidents): self
    {
        $this->incidents = $incidents;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnresponseTime(): int
    {
        return $this->unresponseTime;
    }

    /**
     * @param int $unresponseTime
     */
    public function setUnresponseTime(int $unresponseTime): void
    {
        $this->unresponseTime = $unresponseTime;
    }

    /**
     * @return int
     */
    public function getUnresolutionTime(): int
    {
        return $this->unresolutionTime;
    }

    /**
     * @param int $unresolutionTime
     */
    public function setUnresolutionTime(int $unresolutionTime): void
    {
        $this->unresolutionTime = $unresolutionTime;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
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
     * @return IncidentPriority
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return IncidentPriority
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return IncidentImpact
     */
    public function getImpact(): IncidentImpact
    {
        return $this->impact;
    }

    /**
     * @param IncidentImpact $impact
     * @return IncidentPriority
     */
    public function setImpact(IncidentImpact $impact): self
    {
        $this->impact = $impact;
        return $this;
    }

    /**
     * @return IncidentUrgency
     */
    public function getUrgency(): IncidentUrgency
    {
        return $this->urgency;
    }

    /**
     * @param IncidentUrgency $urgency
     * @return IncidentPriority
     */
    public function setUrgency(IncidentUrgency $urgency): self
    {
        $this->urgency = $urgency;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getSlug();
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
     * @return IncidentPriority
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
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
     * @return IncidentPriority
     */
    public function setIsActive(bool $isActive): IncidentPriority
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * @param int|null $code
     * @return IncidentPriority
     */
    public function setCode(?int $code): IncidentPriority
    {
        $this->code = $code;
        return $this;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return IncidentPriority
     */
    public function setName(?string $name): IncidentPriority
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getResponseTime(): ?int
    {
        return $this->responseTime;
    }

    /**
     * @param int|null $responseTime
     * @return IncidentPriority
     */
    public function setResponseTime(?int $responseTime): IncidentPriority
    {
        $this->responseTime = $responseTime;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getResolutionTime(): ?int
    {
        return $this->resolutionTime;
    }

    /**
     * @param int|null $resolutionTime
     * @return IncidentPriority
     */
    public function setResolutionTime(?int $resolutionTime): IncidentPriority
    {
        $this->resolutionTime = $resolutionTime;
        return $this;
    }


}

