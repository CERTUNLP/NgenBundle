<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Entity\Incident;

use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 *
 * @author dam
 * @ORM\Entity()
 * @ORM\EntityListeners({ "CertUnlp\NgenBundle\Entity\Incident\Listener\ExternalIncidentListener" })
 */
class NetworkExternal extends Network
{
    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $abuse_entity;
    /**
     * @ORM\Column(type="array",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $abuse_entity_emails;

    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $start_address;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $end_address;
    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $country;


    /**
     * @return string
     */
    public function getAbuseEntity(): ?string
    {
        return $this->abuse_entity;
    }

    /**
     * Set abuse_entity
     *
     * @param string $abuse_entity
     * @return NetworkExternal
     */
    public function setAbuseEntity(string $abuse_entity = null): NetworkExternal
    {
        $this->abuse_entity = $abuse_entity;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getNetworkAdmin(): NetworkAdmin
    {
        return $this->abuse_entity;
    }

    /**
     * Get startAddress
     *
     * @return string
     */
    public function getStartAddress(): string
    {
        return $this->start_address;
    }

    /**
     * Set startAddress
     *
     * @param string $startAddress
     *
     * @return NetworkExternal
     */
    public function setStartAddress(string $startAddress): NetworkExternal
    {
        $this->start_address = $startAddress;

        return $this;
    }

    /**
     * Get endAddress
     *
     * @return string
     */
    public function getEndAddress(): string
    {
        return $this->end_address;
    }

    /**
     * Set endAddress
     *
     * @param string $endAddress
     *
     * @return NetworkExternal
     */
    public function setEndAddress(string $endAddress): NetworkExternal
    {
        $this->end_address = $endAddress;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return NetworkExternal
     */
    public function setCountry(string $country): NetworkExternal
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get networkAdminEmails
     *
     * @return array
     */
    public function getAbuseEntityEmails(): array
    {
        return $this->abuse_entity_emails;
    }

    /**
     * Set networkAdminEmails
     *
     * @param array $abuse_entity_emails
     * @return NetworkExternal
     */
    public function setAbuseEntityEmails(array $abuse_entity_emails): NetworkExternal
    {
        $this->abuse_entity_emails = $abuse_entity_emails;

        return $this;
    }

    /**
     * @return array
     */
    public function getEmails(): array
    {
        return $this->abuse_entity_emails;
    }

    /**
     * @return bool
     */
    public function isInternal(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isExternal(): bool
    {
        return true;
    }

}
