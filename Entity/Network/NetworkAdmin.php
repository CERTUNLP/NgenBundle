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

use CertUnlp\NgenBundle\Model\IncidentInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * NetworkAdmin
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\NetworkAdminRepository")
 * @JMS\ExclusionPolicy("all")
 */
class NetworkAdmin
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
     * @ORM\Column(name="name", type="string", length=100)
     * @JMS\Expose()
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true,unique=true)
     * */
    private $slug;

    /**
     * @var array
     *
     * @ORM\Column(name="emails", type="array")
     * @JMS\Expose()
     */
    private $emails = [];

    /**
     * @var string
     *
     */
    private $emailsAsString = [];

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Network\Network",mappedBy="network_admin", cascade={"persist","remove"}))
     */
    private $networks;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Model\IncidentInterface",mappedBy="network_admin", cascade={"persist","remove"}))
     */
    private $incidents;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose()
     */
    private $isActive = true;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;

    /**
     * Constructor
     * @param string $name
     * @param array $emails
     */
    public function __construct(string $name = '', array $emails = [])
    {
        $this->setName($name);
        $this->setEmails($emails);
        $this->networks = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Add networks
     *
     * @param Network $networks
     * @return NetworkAdmin
     */
    public function addNetwork(Network $networks): NetworkAdmin
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
     * @return Collection
     */
    public function getNetworks(): Collection
    {
        return $this->networks;
    }

    public function __toString(): string
    {
        return $this->getName() . ' (' . $this->getEmailsAsString() . ')';
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
     * @return NetworkAdmin
     */
    public function setName(string $name): NetworkAdmin
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get emails
     *
     * @return string
     */
    public function getEmailsAsString(): string
    {
        return $this->emailsAsString;
    }

    /**
     * @param string $emailsAsString
     * @return NetworkAdmin
     */
    public function setEmailsAsString(string $emailsAsString): NetworkAdmin
    {
        $this->emailsAsString = $emailsAsString;
        return $this;
    }

    /**
     * Get emails
     *
     * @return array
     */
    public function getEmails(): array
    {
        return $this->emails;
    }

    /**
     * Set email
     *
     * @param array $emails
     * @return NetworkAdmin
     */
    public function setEmails(array $emails): NetworkAdmin
    {
        $this->emails = $emails;
        $this->setEmailsAsString(implode(',', $this->emails));

        return $this;
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
     * @return NetworkAdmin
     */
    public function setSlug(string $slug): NetworkAdmin
    {
        $this->slug = $slug;

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
     * @return NetworkAdmin
     */
    public function setIsActive(bool $isActive): NetworkAdmin
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Add incidents
     *
     * @param IncidentInterface $incidents
     * @return NetworkAdmin
     */
    public function addIncident(IncidentInterface $incidents): NetworkAdmin
    {
        $this->incidents[] = $incidents;

        return $this;
    }

    /**
     * Remove incidents
     *
     * @param IncidentInterface $incidents
     * @return bool
     */
    public function removeIncident(IncidentInterface $incidents): bool
    {
        return $this->incidents->removeElement($incidents);
    }

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     * @return NetworkAdmin
     */
    public function setCreatedAt(DateTime $createdAt): NetworkAdmin
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     * @return NetworkAdmin
     */
    public function setUpdatedAt(DateTime $updatedAt): NetworkAdmin
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
