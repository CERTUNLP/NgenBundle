<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Constituency;

use CertUnlp\NgenBundle\Entity\Communication\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactEmail;
use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactPhone;
use CertUnlp\NgenBundle\Entity\Communication\Contact\ContactTelegram;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network;
use CertUnlp\NgenBundle\Entity\EntityApiFrontend;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * NetworkAdmin
 *
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\Constituency\NetworkAdminRepository")
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity(
 *     fields={"name"},
 *     errorPath="name",
 *     message="A network adminwith the same name: {{ value }} already exist."
 * )
 */
class NetworkAdmin extends EntityApiFrontend
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
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true,unique=true)
     * @JMS\Expose
     * @JMS\Groups({"read"})
     */
    protected $slug;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     * @JMS\Expose
     * @JMS\Groups({"read","write","fundamental"})
     */
    private $name;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Communication\Contact\Contact",mappedBy="network_admin",cascade={"persist"},orphanRemoval=true)
     * @JMS\Expose
     * @JMS\Groups({"read","write"})
     */
    private $contacts;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network",mappedBy="network_admin"))
     */
    private $networks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->networks = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    /**
     * @return bool
     */
    public function canEditFundamentals(): bool
    {
        return $this->getName() !== 'Undefined';
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
     * @return NetworkAdmin
     */
    public function setName(string $name): NetworkAdmin
    {
        $this->name = $name;

        return $this;
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

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getDeadIncidents(): Collection
    {
        return $this->getIncidents()->filter(static function (Incident $incident) {
            return $incident->isDead();
        });
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function addContact(Contact $contact): NetworkAdmin
    {
        switch ($contact->getContactType()) {
            case 'telegram':
                $new_contact = $contact->castAs(new ContactTelegram());
                break;
            case 'mail' || 'email':
                $new_contact = $contact->castAs(new ContactEmail());
                break;
            case 'phone':
                $new_contact = $contact->castAs(new ContactPhone());
                break;
            default:
                $new_contact = null;

        }
        if ($new_contact && !$this->contacts->contains($new_contact)) {
            $new_contact->setNetworkAdmin($this);
            $this->contacts->add($new_contact);
        }
        return $this;
    }

    public function removeContact(Contact $contact): NetworkAdmin
    {
        $this->contacts->removeElement($contact);
        $contact->setNetworkAdmin();
        return $this;
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

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * Get emails
     *
     * @return string
     */
    public function getEmailsAsString(): string
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
        });
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
     * @return string
     */
    public function getIdentificationString(): string
    {
        return 'id';
    }

    /**
     * {@inheritDoc}
     */
    public function getDataIdentificationArray(): array
    {
        return ['name' => $this->getName()];
    }
}
