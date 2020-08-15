<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\EntityApiFrontend;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * IncidentPriority
 *
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IncidentPriorityRepository")
 * @ORM\EntityListeners({"CertUnlp\NgenBundle\Service\Listener\Entity\IncidentPriorityListener"})
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"impact", "urgency"},
 *     message="This priority already exist."
 * )
 */
class IncidentPriority extends EntityApiFrontend
{
    /**
     * @var integer|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @JMS\Expose()
     * @JMS\Groups({"read"})
     */
    protected $slug;
    /**
     * @var IncidentImpact
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentImpact",inversedBy="incidentsPriorities")
     * @ORM\JoinColumn(name="impact", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $impact = null;
    /**
     *
     * @var IncidentUrgency
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency", inversedBy="incidentsPriorities")
     * @ORM\JoinColumn(name="urgency", referencedColumnName="slug")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $urgency = null;
    /**
     * @var Incident[] | Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="priority",fetch="EXTRA_LAZY")
     */
    private $incidents = null;
    /**
     * @var int
     *
     * @ORM\Column(name="unresponse_time", type="integer")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $unresponseTime = 0;
    /**
     * @var integer|null
     * @ORM\Column(name="unresolution_time", type="integer")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $unresolutionTime;
    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer")
     * @JMS\Expose()
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $code = 0;
    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     * @JMS\Expose()
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $name = '';
    /**
     * @var integer|null
     * @ORM\Column(name="response_time", type="integer")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $responseTime;
    /**
     * @var integer|null
     * @ORM\Column(name="resolution_time", type="integer")
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
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

    /**
     * @return string
     */
    public function getIdentificationString(): string
    {
        return 'id';
    }

    /**
     * @return string
     */
    public function getDataIdentificationString(): string
    {
        return 'code';
    }

    /**
     * {@inheritDoc}
     */
    public function getDataIdentificationArray(): array
    {
        return ['impact' => $this->getImpact()->getId(), 'urgency' => $this->getUrgency()->getId()];
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
}

