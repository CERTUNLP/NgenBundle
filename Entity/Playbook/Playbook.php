<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Description of Playbook
 *
 * @author asanchezg
 */

namespace CertUnlp\NgenBundle\Entity\Playbook;

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\EntityApi;
use CertUnlp\NgenBundle\Entity\User\User;
use DateInterval;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use CertUnlp\NgenBundle\Validator\Constraints as CustomAssert;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use Symfony\Component\Validator\Constraints as Assert;
use CertUnlp\NgenBundle\Entity\Playbook\Phase;

/**
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Playbook\PlaybookRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Playbook extends EntityApi
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phases = new ArrayCollection();
    }

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     * @JMS\Groups({"read"})
     */
    protected $id;
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"id"},separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read"})
     * */
    protected $slug;
    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @JMS\Expose
     * @JMS\Groups({"read","write","fundamental"})
     */
    
    private $name = '';
    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=1024)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $description='';

    /**
     * @var IncidentType
     * @CustomAssert\EntityNotActive()
     * @JMS\Expose
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Incident\IncidentType",inversedBy="playbooks")
     * @ORM\JoinColumn(name="type", referencedColumnName="slug")
     * @JMS\Groups({"read","write","fundamental"})
     * @JMS\MaxDepth(depth=1)
     */
    private $type;

    /**
     * @var Collection | Phase[]
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Playbook\Phase", mappedBy="playbook",cascade={"persist"})
     * @JMS\Expose
     */
    private $phases;
   
    /**
     * @return bool
     */
    public function canEditFundamentals(): bool
    {
        return true;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Entity|Playbook
     */
    public function setId($id): Entity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentificationString(): string
    {
        return 'id';
    }

    public function __toString(): string
    {
        return $this->getSlug();
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug ?: $this->name;
    }

    /**
     * @param string $slug
     * @return Playbook
     */
    public function setSlug(?string $slug): Playbook
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string|null $name
     * @return Playbook
     */
    public function setName(string $name = null): Playbook
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Playbook
     */
    public function setDescription(string $description = null): Playbook
    {
        $this->description = $description;
        return $this;
    }

    /**
     */
    public function getType(): ?IncidentType 
    {
        return $this->type;
    }

    /**
     * @param IncidentType|null $type
     * @return Playbook
     */
    public function setType(IncidentType $type = null): Playbook
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Phase[]|Collection
     */
    public function getPhases(): Collection
    {
        return $this->phases;
    }

    /**
     * @param Phase[]|Collection $phases
     * @return Playbook
     */
    public function setPhases(Collection $phases): self
    {
        $this->phases = $phases;
        return $this;
    }

    /**
     * @param Phase $phase
     * @return $this
     */
    public function addPhase(Phase $phase): self
    {
        if ($phase && !$this->phases->contains($phase)) {
            $phase->setPlaybook($this);
            $this->phases->add($phase);
        }
        return $this;
    }

    public function removePhase(Phase $phase): self
    {
        $this->phases->removeElement($phase);

        return $this;
    }

    /**
     * @return array
     */
    public function getDataIdentificationArray(): array
    {
        return ['type' => $this->getType()->getId()];
    }
}
