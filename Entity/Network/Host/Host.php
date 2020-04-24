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
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Model\Thread;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\HostRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Host extends NetworkElement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    private $id;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    private $createdAt;
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    private $updatedAt;
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * */
    private $slug;
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
    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Host
     */
    public function setId(int $id): Host
    {
        $this->id = $id;
        return $this;
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
     * @return Host
     */
    public function setCreatedAt(DateTime $createdAt): Host
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
     * @return Host
     */
    public function setUpdatedAt(DateTime $updatedAt): Host
    {
        $this->updatedAt = $updatedAt;
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
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return Host
     */
    public function setIsActive(bool $isActive): Host
    {
        $this->isActive = $isActive;
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