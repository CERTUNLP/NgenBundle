<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use DateInterval;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentImpact",inversedBy="incidentsPriorities")
     * @ORM\JoinColumn(name="impact", referencedColumnName="slug")
     * @JMS\Expose
     */
    protected $impact;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency", inversedBy="incidentsPriorities")
     * @ORM\JoinColumn(name="urgency", referencedColumnName="slug")
     * @JMS\Expose
     */

    protected $urgency;


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;


    /**
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="priority"))
     */

    protected $incidents;


    /**
     * @var int
     *
     * @ORM\Column(name="unresponse_time", type="integer")
     * @JMS\Expose
     */
    private $unresponseTime;
    /**
     * @var integer
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
    private $code;


    /**
     * @return mixed
     */

    public function getIncidents()
    {
        return $this->incidents;
    }

    /**
     * @param mixed $incidents
     */
    public function setIncidents($incidents)
    {
        $this->incidents = $incidents;
    }


    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @var string
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
     * @return mixed
     */
    public function getIncidents()
    {
        return $this->incidents;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getImpact()
    {
        return $this->impact;
    }

    /**
     * @param mixed $impact
     */
    public function setImpact($impact)
    {
        $this->impact = $impact;
    }

    /**
     * @return mixed
     */
    public function getUrgency()
    {
        return $this->urgency;
    }

    /**
     * @param mixed $urgency
     */
    public function setUrgency($urgency)
    {
        $this->urgency = $urgency;
    }

    /**@CertUnlpNgenBundle/Resources/public/js/incident/decision/IncidentPriority.js
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getSlug();
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
     *
     * @return IncidentPriority
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get responseTime
     *
     * @return dateinterval
     */
    public function getResponseTime()
    {
        return $this->responseTime;
    }

    /**
     * Set responseTime
     *
     * @param dateinterval $responseTime
     *
     * @return IncidentPriority
     */
    public function setResponseTime($responseTime)
    {
        $this->responseTime = $responseTime;

        return $this;
    }

    /**
     * Get resolutionTime
     *
     * @return int|null
     */
    public function getResolutionTime()
    {
        return $this->resolutionTime;
    }

    /**
     * Set resolutionTime
     *
     * @param dateinterval $resolutionTime
     *
     * @return IncidentPriority
     */
    public function setResolutionTime($resolutionTime)
    {
        $this->resolutionTime = $resolutionTime;

        return $this;
    }

    /**
     * Get code
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return IncidentPriority
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return true;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return IncidentPriority
     */
    public function setIsActive(bool $isActive): IncidentPriority
    {
        $this->isActive = $isActive;

        return $this;
    }

}

