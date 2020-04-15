<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Entity;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * IncidentPriority
 *
 * @ORM\Table(name="incident_priority")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IndicentPriorityRepository")
 * @JMS\ExclusionPolicy("all")
 */
class IncidentPriority extends Entity
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
     * @var IncidentImpact
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentImpact",inversedBy="incidentsPriorities")
     * @ORM\JoinColumn(name="impact", referencedColumnName="slug")
     * @JMS\Expose
     */
    protected $impact;
    /**
     *
     * @var IncidentUrgency
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency", inversedBy="incidentsPriorities")
     * @ORM\JoinColumn(name="urgency", referencedColumnName="slug")
     * @JMS\Expose
     */
    protected $urgency;
    /**
     * @var Incident[] | Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="priority",fetch="EXTRA_LAZY")
     */
    protected $incidents;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;
    /**
     * @var int
     *
     * @ORM\Column(name="unresponse_time", type="integer")
     * @JMS\Expose
     */
    private $unresponseTime = 0;
    /**
     * @var integer|null
     * @ORM\Column(name="unresolution_time", type="integer")
     * @JMS\Expose
     */
    private $unresolutionTime;
    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer")
     * @JMS\Expose
     */
    private $code = 0;
    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @JMS\Expose
     */
    private $slug = '';
    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     * @JMS\Expose
     */
    private $name = '';
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

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'list-ol';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        switch ($this->getCode()) {
            case 1:
            case 2:
                return 'danger';
                break;
            case 3:
                return 'warning';
                break;
            case 4:
                return 'info';
                break;
            case 5:
                return 'primary';
                break;
            default:
                return 'info';
        }
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

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return IncidentPriority
     */
    public function setId(int $id): ?IncidentPriority
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return IncidentImpact
     */
    public function getImpact(): ?IncidentImpact
    {
        return $this->impact;
    }

    /**
     * @param IncidentImpact $impact
     * @return IncidentPriority
     */
    public function setImpact(IncidentImpact $impact): IncidentPriority
    {
        $this->impact = $impact;
        return $this;
    }

    /**
     * @return IncidentUrgency
     */
    public function getUrgency(): ?IncidentUrgency
    {
        return $this->urgency;
    }

    /**
     * @param IncidentUrgency $urgency
     * @return IncidentPriority
     */
    public function setUrgency(IncidentUrgency $urgency): IncidentPriority
    {
        $this->urgency = $urgency;
        return $this;
    }

    /**
     * @return Incident[] | Collection
     */
    public function getIncidents(): ?Collection
    {
        return $this->incidents;
    }

    /**
     * @param Incident[] | Collection $incidents
     * @return IncidentPriority
     */
    public function setIncidents(Collection $incidents): IncidentPriority
    {
        $this->incidents = $incidents;
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
    public function getUnresponseTime(): ?int
    {
        return $this->unresponseTime;
    }

    /**
     * @param int|null $unresponseTime
     * @return IncidentPriority
     */
    public function setUnresponseTime(?int $unresponseTime): IncidentPriority
    {
        $this->unresponseTime = $unresponseTime;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUnresolutionTime(): ?int
    {
        return $this->unresolutionTime;
    }

    /**
     * @param int|null $unresolutionTime
     * @return IncidentPriority
     */
    public function setUnresolutionTime(?int $unresolutionTime): IncidentPriority
    {
        $this->unresolutionTime = $unresolutionTime;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return IncidentPriority
     */
    public function setSlug(?string $slug): IncidentPriority
    {
        $this->slug = $slug;
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
     * @return IncidentPriority
     */
    public function setCreatedAt(?DateTime $createdAt): IncidentPriority
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
     * @return IncidentPriority
     */
    public function setUpdatedAt(?DateTime $updatedAt): IncidentPriority
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getResponseTime(): ?int
    {
        return $this->responseTime ?: 1;
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
        return $this->resolutionTime ?: 1;
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

