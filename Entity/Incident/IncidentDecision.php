<?php

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Network\Network;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * IncidentDecision
 *
 * @ORM\Table(name="incident_decision")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\IncidentDecisionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class IncidentDecision
{

    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose()
     */
    protected $id;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose()
     */
    protected $createdAt;
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose()
     */
    protected $updatedAt;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $type;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentFeed")
     * @ORM\JoinColumn(name="feed", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $feed;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\Network")
     * @ORM\JoinColumn(name="network", referencedColumnName="id")
     * @JMS\Expose()
     */
    protected $network;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentImpact")
     * @ORM\JoinColumn(name="impact", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $impact;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentUrgency")
     * @ORM\JoinColumn(name="urgency", referencedColumnName="slug")
     * @JMS\Expose()
     */
    protected $urgency;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentTlp")
     * @ORM\JoinColumn(name="tlp", referencedColumnName="slug")
     * @JMS\Expose()
     */

    protected $tlp;
    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentState",)
     * @ORM\JoinColumn(name="state", referencedColumnName="slug")
     * @JMS\Expose()
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
     *
     */
    protected $slug;


    /**
     * @var boolean
     *
     * @ORM\Column(name="auto_saved", type="boolean")
     * @JMS\Expose()
     */
    private $autoSaved = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose()
     */
    private $isActive = true;

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
    public function getNetwork(): ?Network
    {
        return $this->network;
    }

    /**
     * @param mixed $network
     * @return IncidentDecision
     */
    public function setNetwork(Network $network = null): IncidentDecision
    {
        $this->network = $network;
        return $this;
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
        $incident->getState() ?: $incident->setStateAndReporter($this->getState(),$incident->getReporter());
        $incident->getType() ?: $incident->setType($this->getType());
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

