<?php

namespace CertUnlp\NgenBundle\Entity\Contact;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * ContactCase
 *
 * @ORM\Table(name="contact_case")
 * @ORM\Entity
 * @JMS\ExclusionPolicy("all")
 */
class ContactCase
{
    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Collection|null
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param Collection|null $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }
    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     * @JMS\Expose
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Id
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=45)
     * @JMS\Expose
     * */
    private $slug;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @JMS\Expose
     */
    private $description;

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Contact\Contact",mappedBy="contactCase"))
     * @JMS\Exclude()
     */

    private $contacts;



    public function __toString()
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
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return IncidentUrgency
     */
    public function setSlug($slug): ContactCase
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @var level
     *
     * @ORM\Column(name="level", type="integer")
     *
     */
    private $level;

    /**
     * @return level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param level $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }
}