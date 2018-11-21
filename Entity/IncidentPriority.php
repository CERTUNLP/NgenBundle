<?php

namespace CertUnlp\NgenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * IncidentPriority
 *
 * @ORM\Table(name="incident_priority")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IndicentPriorityRepository")
 */
class IncidentPriority
{
    /**
     * @var string
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=45)
     * */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var dateinterval
     *
     * @ORM\Column(name="response_time", type="dateinterval")
     */
    private $responseTime;

    /**
     * @var dateinterval
     *
     * @ORM\Column(name="resolution_time", type="dateinterval")
     */
    private $resolutionTime;

    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer", unique=true)
     */
    private $code;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Get responseTime
     *
     * @return dateinterval
     */
    public function getResponseTime()
    {
        return $this->responseTime;
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
     * Get resolutionTime
     *
     * @return dateinterval
     */
    public function getResolutionTime()
    {
        return $this->resolutionTime;
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

    /**
     * Get code
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    public function __toString()
    {
        return $this->slug;
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
     * @return IncidentTlp
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}

