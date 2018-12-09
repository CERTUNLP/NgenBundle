<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * IncidentDecision
 *
 * @ORM\Table(name="incident_decision")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IncidentDecisionRepository")
 */
class IncidentDecision
{

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType",inversedBy="decisions")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     */
    protected $type;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentFeed", inversedBy="decisions")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     */
    protected $feed;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\Network",inversedBy="decisions")
     * @ORM\JoinColumn(name="network", referencedColumnName="id")
     */
    protected $network;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentImpact",inversedBy="decisions")
     * @ORM\JoinColumn(name="impact", referencedColumnName="slug")
     */
    protected $impact;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency", inversedBy="decisions")
     * @ORM\JoinColumn(name="urgency", referencedColumnName="slug")
     */
    protected $urgency;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentTlp", inversedBy="decisions")
     * @ORM\JoinColumn(name="tlp", referencedColumnName="slug")
     */

    protected $tlp;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState", inversedBy="decisions")
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     */
    protected $state;
    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=100)
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\RelativeSlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="relationField", value="type"),
     *          @Gedmo\SlugHandlerOption(name="relationSlugField", value="slug"),
     *          @Gedmo\SlugHandlerOption(name="separator", value="_")
     *      })
     * }, fields={"id"})
     */
    protected $slug;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var boolean
     *
     * @ORM\Column(name="auto_saved", type="boolean")
     */
    private $autoSaved = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = true;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->incidents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getType() . '_' . $this->getFeed();
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * @param mixed $feed
     */
    public function setFeed($feed)
    {
        $this->feed = $feed;
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

    /**
     * Get id
     *
     * @return int
     */
    public function setId($id)
    {
        return $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * @param mixed $network
     */
    public function setNetwork($network)
    {
        $this->network = $network;
    }

    /**
     * @return bool
     */
    public function isAutoSaved(): bool
    {
        return $this->autoSaved;
    }

    /**
     * @param bool $autoSaved
     */
    public function setAutoSaved(bool $autoSaved)
    {
        $this->autoSaved = $autoSaved;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
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
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @return IncidentDecision
     */
    public function setSlug(string $slug): IncidentDecision
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param Incident $incident
     * @return Incident
     */
    public function doDecision(Incident $incident): Incident
    {
        $incident->getTlp() ?: $incident->setTlp($this->getTlp());
        $incident->getImpact() ?: $incident->setImpact($this->getImpact());
        $incident->getUrgency() ?: $incident->setUrgency($this->getUrgency());
        $incident->getState() ?: $incident->setState($this->getState());
        return $incident;
    }

    /**
     * @return mixed
     */
    public function getTlp()
    {
        return $this->tlp;
    }

    /**
     * @param mixed $tlp
     */
    public function setTlp($tlp)
    {
        $this->tlp = $tlp;
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

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

}

