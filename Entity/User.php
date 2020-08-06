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

use CertUnlp\NgenBundle\Entity\Communication\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactEmail;
use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactPhone;
use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactTelegram;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Model\EntityApiFrontendInterface;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"username"},
 *     message="This username is already in use."
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="This email is already in use."
 * )
 * @ORM\HasLifecycleCallbacks
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser implements EntityApiFrontendInterface
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
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    protected $username;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    protected $email;

    /**
     * @var bool
     * @JMS\Expose
     * @JMS\SerializedName("active")
     * @JMS\Groups({"read","write"})
     */
    protected $enabled;
    /**
     * @var DateTime|null
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    protected $lastLogin;

    /**
     * @var GroupInterface[]|Collection
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    protected $groups;

    /**
     * @var array
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    protected $roles;
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"firstname","lastname"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * */
    protected $slug;
    /**
     * @ORM\Column(name="api_key", type="string", length=255, nullable=true)
     */
    private $apiKey;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $firstname = '';
    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $lastname = '';
    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Groups({"read"})
     */
    private $createdAt;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Groups({"read"})
     */
    private $updatedAt;
    /**
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="reporter",fetch="EXTRA_LAZY")
     */
    private $incidents;
    /**
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Incident\Incident",mappedBy="assigned",fetch="EXTRA_LAZY")
     */
    private $assignedIncidents;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Communication\Contact\Contact",mappedBy="user",cascade={"persist"},orphanRemoval=true)
     * @JMS\Expose()
     * @JMS\Groups({"read","write"})
     */
    private $contacts;
    /**
     * @var int|null
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\User")
     * @Gedmo\Blameable(on="create")
     */
    private $createdBy;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->incidents = new ArrayCollection();
        $this->assignedIncidents = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'users';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'info';
    }

    /**
     * Get emails
     *
     * @return string
     */
    public function getEmailsAsString(): ?string
    {
        return implode(',', $this->getEmails());
    }

    /**
     * Get emails
     *
     * @return array
     */
    public function getEmails(): array
    {
        $array_mails = $this->getContacts()->map(static function (Contact $value) {
            return $value->getEmail();
        }); // [2, 3, 4]
        return $array_mails->toArray();
    }

    /**
     * @param int|null $priorityCode
     * @return Collection
     */
    public function getContacts(int $priorityCode = null): Collection
    {
        if ($priorityCode !== null) {
            return $this->contacts->filter(static function (Contact $contact) use ($priorityCode) {
                return $contact->getContactCase()->getLevel() >= $priorityCode;
            });
        }

        return $this->contacts;
    }

    /**
     * Get emails
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isEnabled();
    }

    /**
     * @return Collection|Incident[]|null
     */
    public function getAssignedIncidents(): ?Collection
    {
        return $this->assignedIncidents;
    }

    /**
     * @param Collection|Incident[] $assignedIncidents
     * @return User
     */
    public function setAssignedIncidents(Collection $assignedIncidents): User
    {
        $this->assignedIncidents = $assignedIncidents;
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
     * @return User
     */
    public function setUpdatedAt(DateTime $updatedAt): User
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function timestampsUpdate(): void
    {
        $this->setUpdatedAt(new DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTime('now'));
        }
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     * @return User
     */
    public function setCreatedAt(DateTime $createdAt): User
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Add incidents
     *
     * @param Incident $incidents
     * @return User
     */
    public function addIncident(Incident $incidents): User
    {
        $this->incidents[] = $incidents;

        return $this;
    }

    /**
     * @return Collection| Incident[]
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    public function __toString(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Set name
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * Get name
     *
     * @return string
     * @JMS\VirtualProperty()
     * @JMS\Expose()
     *
     */
    public function getFullName(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * Get apiKey
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Set apiKey
     *
     * @param string $apiKey
     * @return User
     */
    public function setApiKey(string $apiKey): User
    {
        $this->apiKey = $apiKey;

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
     * @return User
     */
    public function setSlug(string $slug): User
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @param Contact $contact
     * @return $this
     * @throws ClassNotFoundException
     */
    public function addContact(Contact $contact): User
    {
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
            default:
                throw new ClassNotFoundException('Contact class: "' . $contact->getContactType() . '" does not exist.', null);

        }

        if (!$this->contacts->contains($newObj)) {
            $newObj->setUser($this);
        }

        $this->contacts->add($newObj);

        return $this;

    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function removeContact(Contact $contact): User
    {
        $this->contacts->removeElement($contact);
        $contact->setNetworkAdmin(null);
        return $this;
    }


    /**
     * @return User
     */
    public function activate(): EntityApiInterface
    {
        $this->setEnabled(true);
        return $this;
    }

    /**
     * @return User
     */
    public function desactivate(): EntityApiInterface
    {
        $this->setEnabled(false);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    /**
     * @return array
     */
    public function getIdentificationArray(): array
    {
        return [$this->getIdentificationString() => $this->getId()];
    }

    /**
     * @return string
     */
    public function getIdentificationString(): string
    {
        return 'id';
    }

    public function getDataIdentificationArray(): array
    {
        return ['username' => $this->getUsername()];
    }
}