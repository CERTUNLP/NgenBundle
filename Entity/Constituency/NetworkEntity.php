<?php
/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Constituency;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network\Network;
use CertUnlp\NgenBundle\Entity\EntityApi;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * NetworkEntity
 *
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class NetworkEntity extends EntityApi
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
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"read"})
     */
    protected $slug = '';
    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     * @JMS\Expose
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $name = '';
    /**
     * @var Network
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network\Network",mappedBy="network_entity"))
     */
    private $networks;

    /**
     * Constructor
     * @param string $name
     */
    public function __construct(string $name = null)
    {
        $this->setName($name);
        $this->networks = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getIdentificationString(): string
    {
        return 'id';
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return NetworkEntity
     */
    public function setSlug(string $slug): NetworkEntity
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'sitemap';
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
    public function __toString(): string
    {
        return $this->getName();
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
     * @param string $name
     * @return NetworkEntity
     */
    public function setName(string $name = null): NetworkEntity
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add networks
     *
     * @param Network $networks
     * @return NetworkEntity
     */
    public function addNetwork(Network $networks): NetworkEntity
    {
        $this->networks[] = $networks;

        return $this;
    }

    /**
     * Remove networks
     *
     * @param Network $networks
     * @return bool
     */
    public function removeNetwork(Network $networks): bool
    {
        return $this->networks->removeElement($networks);
    }

    /**
     * Get networks
     *
     * @return Network[]|Collection
     */
    public function getNetworks(): Collection
    {
        return $this->networks;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getDataIdentificationArray(): array
    {
        return ['name' => $this->getName()];
    }
}
