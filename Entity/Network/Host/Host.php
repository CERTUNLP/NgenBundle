<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Network\Host;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkElement;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Model\Thread;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\HostRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Host extends NetworkElement
{

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * */
    protected $slug;
    /**
     * @var Network
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\Network", inversedBy="hosts", cascade={"persist"})
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $network;
    /**
     * @var Incident[]|Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="origin",fetch="EXTRA_LAZY")
     * @JMS\Exclude()
     */
    private $incidents_as_origin;
    /**
     * @var Incident[]|Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="destination",fetch="EXTRA_LAZY")
     */
    private $incidents_as_destination;
    private $comment_thread;

    public function __construct(?string $term = null)
    {
        parent::__construct($term);
        $this->incidents_as_origin = new ArrayCollection();
        $this->incidents_as_destination = new ArrayCollection();
    }


    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'laptop';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'info';
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
     * @return Host
     */
    public function setSlug(string $slug): Host
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return Network
     */
    public function getNetwork(): ?Network
    {
        return $this->network;
    }

    /**
     * @param Network $network
     * @return Host
     */
    public function setNetwork(Network $network = null): Host
    {
        $this->network = $network;
        return $this;
    }

    /**
     * /**
     * @return Thread
     */
    public function getCommentThread(): Thread
    {
        return $this->comment_thread;
    }

    /**
     * @param Thread $comment_thread
     * @return Host
     */
    public function setCommentThread(Thread $comment_thread): Host
    {
        $this->comment_thread = $comment_thread;
        return $this;
    }

    /**
     * Get incidents
     *
     * @param string $type
     * @return Collection
     */
    public function getliveIncidentsAsOriginOfType(string $type): Collection
    {
        return $this->getliveIncidentsAsOrigin()->filter(static function (Incident $incident) use ($type) {
            return $incident->getType()->getSlug() === $type;
        });
    }

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getliveIncidentsAsOrigin(): Collection
    {
        return $this->getIncidentsAsOrigin()->filter(static function (Incident $incident) {
            return $incident->isLive();
        });
    }

    /**
     * @return Incident[]|Collection
     */
    public function getIncidentsAsOrigin(): Collection
    {
        return $this->incidents_as_origin;
    }

    /**
     * @param Incident[]|Collection $incidents_as_origin
     * @return Host
     */
    public function setIncidentsAsOrigin(Collection $incidents_as_origin): self
    {
        $this->incidents_as_origin = $incidents_as_origin;
        return $this;
    }

    /**
     * @return Incident[]|Collection
     */
    public function getIncidents(): Collection
    {
        return $this->getIncidentsAsOrigin();
    }

    /**
     * @return Incident[]|Collection
     */
    public function getIncidentsAsDestination(): Collection
    {
        return $this->incidents_as_destination;
    }

    /**
     * @param Incident[]|Collection $incidents_as_destination
     * @return Host
     */
    public function setIncidentsAsDestination(Collection $incidents_as_destination): self
    {
        $this->incidents_as_destination = $incidents_as_destination;
        return $this;
    }
}