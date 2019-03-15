<?php

namespace CertUnlp\NgenBundle\Entity\Contact;

use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\ContactRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"contact"="Contact","telegram" = "ContactTelegram", "phone" = "ContactPhone", "email" = "ContactEmail", "threema"="ContactThreema"})
 * @JMS\ExclusionPolicy("all")
 */
class Contact
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var NetworkAdmin|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\NetworkAdmin", inversedBy="contacts")
     */
    private $network_admin;

    /**
     * @var NetworkAdmin|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User", inversedBy="contacts")
     */
    private $user;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contact_type", type="string", length=255)
     */
    private $contactType;

    /**
     * @var ContactCase|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Contact\ContactCase", inversedBy="contacts")
     * @ORM\JoinColumn(name="contact_case", referencedColumnName="slug")
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $contactCase;
    /**
     * @var string|null
     *
     * @ORM\Column(name="encryption_key", type="string", length=4000, nullable=true)
     */
    private $encryptionKey;

    public function getEmail(): string
    {
        return '';
    }

    public function getTelegram(): string
    {
        return '';

    }

    /**
     * @return NetworkAdmin
     */
    public function getNetworkAdmin(): ?NetworkAdmin
    {
        return $this->network_admin;
    }

    /**
     * @param NetworkAdmin $network_admin
     * @return Contact
     */
    public function setNetworkAdmin(NetworkAdmin $network_admin = null): Contact
    {
        $this->network_admin = $network_admin;
        return $this;
    }

    /**
     * @return string
     */
    public function getContactType(): ?string
    {
        return $this->contactType;
    }

    /**
     * @param string $contactType
     * @return Contact
     */
    public function setContactType(string $contactType): Contact
    {
        $this->contactType = $contactType;
        return $this;
    }

    /**
     * @return ContactCase
     */
    public function getContactCase(): ?ContactCase
    {
        return $this->contactCase;
    }

    /**
     * @param ContactCase $contactCase
     * @return Contact
     */
    public function setContactCase(ContactCase $contactCase): Contact
    {
        $this->contactCase = $contactCase;
        return $this;

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
     * Get name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Contact
     */
    public function setName(string $name): Contact
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Contact
     */
    public function setUsername(string $username): Contact
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get encryptionKey
     *
     * @return string
     */
    public function getEncryptionKey(): ?string
    {
        return $this->encryptionKey;
    }

    /**
     * Set encryptionKey
     *
     * @param string $encryptionKey
     * @return Contact
     */
    public function setEncryptionKey(string $encryptionKey): Contact
    {
        $this->encryptionKey = $encryptionKey;

        return $this;
    }

    /**
     * @param $contact
     * @return mixed
     */
    public function castAs(Contact $contact): Contact
    {
        foreach (get_object_vars($this) as $key => $name) {
            $contact->$key = $name;
        }
        return $contact;
    }

    /**
     * @return NetworkAdmin|null
     */
    public function getUser(): ?NetworkAdmin
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Contact
     */
    public function setUser(User $user = null): Contact
    {
        $this->user = $user;
        return $this;
    }
}
