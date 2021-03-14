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
 * Description of PlaybookElement
 *
 * @author asanchezg
 */

namespace CertUnlp\NgenBundle\Entity\Playbook;

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\EntityApi;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use CertUnlp\NgenBundle\Entity\Playbook\Phase;

 /**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"playbook-element" = "PlaybookElement", "phase"="Phase","task" = "Task"})
 * @JMS\ExclusionPolicy("all")
 */

class PlaybookElement extends EntityApi
{
    /**
     * @var integer
     *
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
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
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Playbook\Phase", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     * @JMS\Groups({"read","write","fundamental"})
     * @JMS\Expose
     */
    private $parent;

    /**
     * @return Phase
     */
    public function getParent(): ?PlaybookElement 
    {
        return $this->parent;
    }

    /**
     * @param PlaybookElement|null $parent
     * @return Task
     */
    public function setParent(PlaybookElement $parent =null): Task
    {
        $this->parent = $parent;
        return $this;
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
        return $this->slug ?: 'ss';
    }

    /**
     * @param string $slug
     * @return PlaybookElement
     */
    public function setSlug(?string $slug): PlaybookElement
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
     * {@inheritDoc}
     */
    public function getDataIdentificationArray(): array
    {
        return ['name' => $this->getName()];
    }
}
