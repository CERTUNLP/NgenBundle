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
    /**
     * @var int|null
     *
     * @ORM\Column(name="level", type="integer")
     *
     */
    private $level;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return ContactCase
     */
    public function setName(string $name): ?ContactCase
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getContacts(): ?Collection
    {
        return $this->contacts;
    }

    /**
     * @param Collection|null $contacts
     * @return ContactCase
     */
    public function setContacts(Collection $contacts): ?ContactCase
    {
        $this->contacts = $contacts;
        return $this;

    }

    /**
     * @return string
     */
    public function __toString(): ?string
    {
        return $this->getSlug();
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return ContactCase
     */
    public function setDescription(string $description): ?ContactCase
    {
        $this->description = $description;
        return $this;
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
     * @return ContactCase
     */
    public function setSlug(string $slug): ?ContactCase
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @param $level
     * @return bool
     */
    public function needToContact(int $level): ?bool
    {
        return ($level >= $this->getLevel());
    }

    /**
     * @return int
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return ContactCase
     */
    public function setLevel(int $level): ?ContactCase
    {
        $this->level = $level;
        return $this;

    }
}