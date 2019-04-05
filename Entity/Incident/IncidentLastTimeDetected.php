<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * IncidentLastTimeDetected
 *
 * @ORM\Table(name="incident_last_time_detected")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class IncidentLastTimeDetected
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

      /**
     * @return Incident
     */
    public function getIncident()
    {
        return $this->incident;
    }

    /**
     * @param Incident $incident
     */
    public function setIncident($incident)
    {
        $this->incident = $incident;
    }

    /**
     * @return DateTime
     */
    public function getDateDetected()
    {
        return $this->dateDetected;
    }

    /**
     * @param DateTime $dateDetected
     */
    public function setDateDetected($dateDetected)
    {
        $this->dateDetected = $dateDetected;
    }


    /**
     * @var Incident
     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident", inversedBy="lastTimeDetected")
     *
     * */
    protected $incident;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_detected", type="datetime",nullable=true)
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    private $dateDetected;

    /**
     * @var IncidentFeed
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentFeed")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @Assert\NotNull
     */
    protected $feed;

    /**
     * @return IncidentFeed
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * @param IncidentFeed $feed
     */
    public function setFeed($feed)
    {
        $this->feed = $feed;
    }

}