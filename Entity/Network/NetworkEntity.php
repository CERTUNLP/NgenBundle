<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Network;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * NetworkEntity
 *
 * @ORM\Table()
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class NetworkEntity
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     * @JMS\Expose
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * */
    private $slug;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Network\Network",mappedBy="network_entity")) */
    private $networks;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose
     */
    private $isActive = true;


    /**
     * Constructor
     * @param null $name
     */
    public function __construct($name = null)
    {
        $this->setName($name);
        $this->networks = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function setName(string $name): NetworkEntity
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
     * Get slug
     *
     * @return string
     */
    public function getSlug(): string
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
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return NetworkEntity
     */
    public function setCreatedAt(\DateTime $createdAt): NetworkEntity
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return NetworkEntity
     */
    public function setUpdatedAt(\DateTime $updatedAt): NetworkEntity
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return NetworkEntity
     */
    public function setIsActive(bool $isActive): NetworkEntity
    {
        $this->isActive = $isActive;

        return $this;
    }

}
