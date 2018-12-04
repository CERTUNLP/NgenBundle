<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Entity\Incident;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * Description of InternalIncident
 *
 * @author dam
 */
class ExternalIncident
{

    /**
     * @var string
     *
     * @ORM\Column(name="host_address", type="string", length=20)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $ip;

//    /**
//     * @ORM\Column(name="network", type="string",nullable=true)
//     * @JMS\Expose
//     */
//    private $network;
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"ip"},separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * */
    protected $slug;
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
    private $network_entity;
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
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Incident
     */
    public function setHostAddress($ip)
    {
        $this->ip = $ip;
        return $this;
    }
//
//    /**
//     * Set network
//     *
//     * @return Incident
//     */
//    public function setNetwork(NetworkInterface $network = null) {
//        $this->network = $network;
//
//        return $this;
//    }
//
//    /**
//     * Get network
//     *
//     */
//    public function getNetwork() {
//        return $this->network;
//    }

    /**
     * Get abuse_entity
     *
     */
    public function getAbuseEntity()
    {
        return $this->abuse_entity;
    }

    /**
     * Set abuse_entity
     *
     * @param null $abuse_entity
     * @return Incident
     */
    public function setAbuseEntity($abuse_entity = null)
    {
        $this->abuse_entity = $abuse_entity;

        return $this;
    }

    /**
     * Get abuse_entity
     *
     */
    public function getNetworkAdmin()
    {
        return $this->abuse_entity;
    }

    /**
     * Get network_entity
     *
     */
    public function getNetworkEntity()
    {
        return $this->network_entity;
    }

    /**
     * Set network_entity
     *
     * @param null $network_entity
     * @return Incident
     */
    public function setNetworkEntity($network_entity = null)
    {
        $this->network_entity = $network_entity;

        return $this;
    }

    /**
     * Get startAddress
     *
     * @return string
     */
    public function getStartAddress()
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
    public function setStartAddress($startAddress)
    {
        $this->start_address = $startAddress;

        return $this;
    }

    /**
     * Get endAddress
     *
     * @return string
     */
    public function getEndAddress()
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
    public function setEndAddress($endAddress)
    {
        $this->end_address = $endAddress;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
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
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get networkAdminEmails
     *
     * @return array
     */
    public function getAbuseEntityEmails()
    {
        return $this->abuse_entity_emails;
    }

    /**
     * Set networkAdminEmails
     *
     * @param $abuse_entity_emails
     * @return NetworkExternal
     */
    public function setAbuseEntityEmails($abuse_entity_emails)
    {
        $this->abuse_entity_emails = $abuse_entity_emails;

        return $this;
    }

    /**
     * Get abuse_entity_emails
     *
     * @return array
     */
    public function getEmails()
    {
        return $this->abuse_entity_emails;
    }

    public function isInternal()
    {
        return false;
    }

    public function isExternal()
    {
        return true;
    }

}
