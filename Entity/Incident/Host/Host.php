<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Incident\Host;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentCommentThread;
use CertUnlp\NgenBundle\Entity\Network\Network;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\EntityListeners({ "CertUnlp\NgenBundle\Entity\Incident\Host\Listener\HostListener" })
 */
class Host
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
     * @var string
     *
     * @ORM\Column(type="string", length=15, nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @Assert\Ip(version="4_no_priv")
     */
    private $ip_v4;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=39, nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * @Assert\Ip(version="6_no_priv")
     */
    private $ip_v6;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     *
     * @Assert\Url()
     * )
     */
    private $url;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     * @JMS\Groups({"api"})
     */
    private $createdAt;

    /**
     * @var \DateTime
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
     * @Gedmo\Slug(fields={"ip_v4"},separator="_")
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
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="origin"))
     */
    private $incidents_as_origin;

    /**
     * @var Incident[]|Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="destination"))
     */
    private $incidents_as_destination;
    /**
     * @var IncidentCommentThread
     * @ORM\OneToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentCommentThread",mappedBy="host",fetch="EXTRA_LAZY"))
     */
    private $comment_thread;
    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;


    /**
     * Host constructor.
     * @param string $ip_v4
     */
    public function __construct(string $ip_v4 = null)
    {
        $this->ip_v4 = $ip_v4;
        $this->incidents_as_origin = new ArrayCollection();
        $this->incidents_as_destination = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getSlug();
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
     * @return string
     */
    public function getIpV6(): string
    {
        return $this->ip_v6;
    }

    /**
     * @param string $ip_v6
     * @return Host
     */
    public function setIpV6(string $ip_v6): Host
    {
        $this->ip_v6 = $ip_v6;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Host
     */
    public function setUrl(string $url): Host
    {
        $this->url = $url;
        return $this;
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
     * @return Host
     */
    public function setCreatedAt(\DateTime $createdAt): Host
    {
        $this->createdAt = $createdAt;
        return $this;
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
     * @return Host
     */
    public function setUpdatedAt(\DateTime $updatedAt): Host
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
    public function setNetwork(Network $network): Host
    {
        $this->network = $network;
        return $this;
    }

    /**
     * /**
     * @return IncidentCommentThread
     */
    public function getCommentThread(): IncidentCommentThread
    {
        return $this->comment_thread;
    }

    /**
     * @param IncidentCommentThread $comment_thread
     * @return Host
     */
    public function setCommentThread(IncidentCommentThread $comment_thread): Host
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
     * @param Host|null $other
     * @return bool
     */
    public function equals(Host $other = null): bool
    {
        if ($other) {
            return ($this->getIpV4() === $other->getIpV4());
        }
        return false;

    }

    /**
     * @return string
     */
    public function getIpV4(): ?string
    {
        return $this->ip_v4;
    }

    /**
     * @param string $ip_v4
     * @return Host
     */
    public function setIpV4(string $ip_v4): Host
    {
        $this->ip_v4 = $ip_v4;
        return $this;
    }

    /**
     * @return Incident[]|Collection
     */
    public function getIncidentsAsOrigin()
    {
        return $this->incidents_as_origin;
    }

    /**
     * @param Incident[]|Collection $incidents_as_origin
     * @return Host
     */
    public function setIncidentsAsOrigin($incidents_as_origin)
    {
        $this->incidents_as_origin = $incidents_as_origin;
        return $this;
    }

    /**
     * @return Incident[]|Collection
     */
    public function getIncidentsAsDestination()
    {
        return $this->incidents_as_destination;
    }

    /**
     * @param Incident[]|Collection $incidents_as_destination
     * @return Host
     */
    public function setIncidentsAsDestination($incidents_as_destination)
    {
        $this->incidents_as_destination = $incidents_as_destination;
        return $this;
    }

}