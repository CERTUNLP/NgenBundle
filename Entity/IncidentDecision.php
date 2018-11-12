<?php

namespace CertUnlp\NgenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IncidentDecision
 *
 * @ORM\Table(name="incident_decision")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IncidentDecisionRepository")
 */

class IncidentDecision
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentType",inversedBy="incidentsDecisions")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentFeed", inversedBy="incidentsDecisions")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     */
    protected $feed;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network",inversedBy="incidentsDecisions")
     * @ORM\JoinColumn(name="network", referencedColumnName="id")
     */
    protected $network;


    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentImpact",inversedBy="incidentsDecisions")
     * @ORM\JoinColumn(name="impact", referencedColumnName="slug")
     */
    protected $impact;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentUrgency", inversedBy="incidentsDecisions")
     * @ORM\JoinColumn(name="urgency", referencedColumnName="slug")
     */
    protected $urgency;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentTlp", inversedBy="incidentsDecisions")
     * @ORM\JoinColumn(name="tlp", referencedColumnName="slug")
     */

    protected $tlp;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\IncidentState", inversedBy="incidentsDecisions")
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     */
    protected $state;

    /**
     * @var boolean
     *
     * @ORM\Column(name="autoSaved", type="boolean", nullable=true)
     */
    private $autoSaved;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->incidents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}

