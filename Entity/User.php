<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity;

use CertUnlp\NgenBundle\Entity\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Contact\ContactEmail;
use CertUnlp\NgenBundle\Entity\Contact\ContactPhone;
use CertUnlp\NgenBundle\Entity\Contact\ContactTelegram;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Model\ReporterInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser implements ReporterInterface
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
     * @ORM\Column(name="api_key", type="string", length=255, nullable=true)
     */
    protected $apiKey;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     * @JMS\Expose()
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     * @JMS\Expose()
     */
    private $lastname;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="reporter") */
    private $incidents;
    /** @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="assigned") */
    private $assignedIncidents;
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name","lastname"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * */
    private $slug;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Contact\Contact",mappedBy="user",cascade={"persist"},orphanRemoval=true)
     */
    private $contacts;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->incidents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->assignedIncidents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAssignedIncidents()
    {
        return $this->assignedIncidents;
    }

    /**
     * @param mixed $assignedIncidents
     */
    public function setAssignedIncidents($assignedIncidents)
    {
        $this->assignedIncidents = $assignedIncidents;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function timestampsUpdate()
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Add incidents
     *
     * @param \CertUnlp\NgenBundle\Entity\Incident\Incident $incidents
     * @return User
     */
    public function addIncident(Incident $incidents)
    {
        $this->incidents[] = $incidents;

        return $this;
    }

    /**
     * Remove incidents
     *
     * @param \CertUnlp\NgenBundle\Entity\Incident\Incident $incidents
     */
    public function removeIncident(Incident $incidents)
    {
        $this->incidents->removeElement($incidents);
    }

    /**
     * Get incidents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIncidents()
    {
        return $this->incidents;
    }

    public function __toString()
    {
        return $this->getName() . ' ' . $this->getLastname();
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     * @JMS\VirtualProperty()
     * @JMS\Expose()
     *
     */
    public function getFullName()
    {
        return $this->getName() . ' ' . $this->getLastname();
    }

    /**
     * Get apiKey
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set apiKey
     *
     * @param string $apiKey
     * @return User
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return User
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact)
    {
        $newObj = $contact;
        switch ($contact->getContactType()) {
            case 'telegram':
                $newObj = $contact->castAs(new ContactTelegram());
                break;
            case 'mail':
                $newObj = $contact->castAs(new ContactEmail());
                break;
            case 'phone':
                $newObj = $contact->castAs(new ContactPhone());
                break;
        }

        if (!$this->contacts->contains($newObj)) {
            $newObj->setUser($this);
        }
        $this->contacts->add($newObj);
        return $this;

    }

    public function removeContact(Contact $contact)
    {
        $this->contacts->removeElement($contact);
        $contact->setNetworkAdmin(null);
//        if ($this->contacts->contains($contact)){
//
//        }
        return $this;
    }


}
