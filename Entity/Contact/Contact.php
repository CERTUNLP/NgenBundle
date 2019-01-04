<?php

namespace CertUnlp\NgenBundle\Entity\Contact;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */


    private $name;

  /**
     * @var network_admin
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\Network\NetworkAdmin", inversedBy="contacts")
     */

    private $network_admin;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_type", type="string", length=255)
     */
    private $contactType;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_case", type="string", length=255)
     */
    private $contactCase;

    /**
     * @return network_admin
     */
    public function getNetworkAdmin()
    {
        return $this->network_admin;
    }

    /**
     * @param network_admin $network_admin
     */
    public function setNetworkAdmin($network_admin)
    {
        $this->network_admin = $network_admin;
    }

    /**
     * @return string
     */
    public function getContactType()
    {
        return $this->contactType;
    }

    /**
     * @param string $contactType
     */
    public function setContactType($contactType)
    {
        $this->contactType = $contactType;
    }

    /**
     * @return string
     */
    public function getContactCase()
    {
        return $this->contactCase;
    }

    /**
     * @param string $contactCase
     */
    public function setContactCase($contactCase)
    {
        $this->contactCase = $contactCase;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="encryption_key", type="string", length=4000, nullable=true)
     */
    private $encryptionKey;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set username
     *
     * @param string $username
     * @return Contact
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set encryptionKey
     *
     * @param string $encryptionKey
     * @return Contact
     */
    public function setEncryptionKey($encryptionKey)
    {
        $this->encryptionKey = $encryptionKey;

        return $this;
    }

    /**
     * Get encryptionKey
     *
     * @return string 
     */
    public function getEncryptionKey()
    {
        return $this->encryptionKey;
    }
}
