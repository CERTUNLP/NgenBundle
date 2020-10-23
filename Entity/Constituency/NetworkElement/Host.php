<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Constituency\NetworkElement;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Model\Thread;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Constituency\NetworkElement\HostRepository")
 * @ORM\EntityListeners({"CertUnlp\NgenBundle\Service\Listener\Entity\HostListener"})
 * @JMS\ExclusionPolicy("all")
 * @JMS\AccessorOrder("custom", custom = {"active", "address" ,"network","created_at","updated_at"})
 * @UniqueEntity(
 *     fields={"domain"},
 *     errorPath="address",
 *     message="A host with the same address: {{ value }} already exist."
 * )
 * @UniqueEntity(
 *     fields={"ip"},
 *     errorPath="address",
 *     message="A host with the same address: {{ value }} already exist."
 * )
 */
class Host extends NetworkElement
{

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose()
     * @JMS\Groups({"read"})
     * */
    protected $slug;
    /**
     * @var Network
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network", inversedBy="hosts", cascade={"persist"}))
     * @JMS\Expose()
     * @JMS\Groups({"read","write","list"})
     */
    private $network;
    /**
     * @var Network
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $temp_network = null;
    /**
     * @var Incident[]|Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="origin",fetch="EXTRA_LAZY", cascade={"persist"})
     */
    private $incidents;

    private $comment_thread;

    public function __construct(?string $term = null)
    {
        parent::__construct($term);
        $this->incidents = new ArrayCollection();
    }

    /**
     * @return Network
     */
    public function getTempNetwork(): ?Network
    {
        return $this->temp_network;
    }

    /**
     * @param Network|null $temp_network
     * @return Host
     */
    public function setTempNetwork(Network $temp_network = null): Host
    {
        $this->temp_network = $temp_network;
        return $this;
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
     * @param Network|null $network
     * @return Host
     */
    public function setNetwork(Network $network = null): Host
    {
        $this->network = $network;
        foreach ($this->getIncidents() as $incident) {
            if (!$this->getNetwork()->equals($incident->getNetwork())) {
                $incident->setNetwork($this->getNetwork());
            }
        }
        return $this;
    }

    /**
     * @return Incident[]|Collection
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
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
    public function canEditFundamentals(): bool
    {
        return $this->getDeadIncidents()->isEmpty();
    }

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getDeadIncidents(): Collection
    {
        return $this->getIncidents()->filter(static function (Incident $incident) {
            return $incident->isDead();
        });
    }

    /**
     * Get incidents
     *
     * @param string $type
     * @return Collection
     */
    public function getliveIncidentOfType(string $type): Collection
    {
        return $this->getliveIncidents()->filter(static function (Incident $incident) use ($type) {
            return $incident->getType()->getSlug() === $type;
        });
    }

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getliveIncidents(): Collection
    {
        return $this->getIncidents()->filter(static function (Incident $incident) {
            return $incident->isLive();
        });
    }

    public function addIncident(Incident $incident): ?Host
    {
        if ($this->incidents->contains($incident)) {
            return $this;
        }
        $this->incidents[] = $incident;
        $incident->setOrigin($this);
        return $this;

    }

    public function removeIncident(Incident $incident): ?Host
    {
        if (!$this->incidents->contains($incident)) {
            return $this;
        }
        $this->incidents->removeElement($incident);
        $incident->setOrigin(null);
        return $this;

    }

}