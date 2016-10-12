<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CertUnlp\NgenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use CertUnlp\NgenBundle\Model\ReporterInterface;
use CertUnlp\NgenBundle\Model\IncidentInterface;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of InternalIncident
 *
 * @author dam
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Entity\ExternalIncidentRepository")
 * @ORM\EntityListeners({ "CertUnlp\NgenBundle\Entity\Listener\ExternalIncidentListener" })
 */
class ExternalIncident extends Incident {

    /**
     * @var string
     *
     * @ORM\Column(name="host_address", type="string", length=20)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    protected $hostAddress;

//    /**
//     * @ORM\Column(name="network", type="string",nullable=true)
//     * @JMS\Expose
//     */
//    private $network;

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
     * @var string
     * 
     * @Gedmo\Slug(fields={"hostAddress"},separator="_")     
     * @ORM\Column(name="slug", type="string", length=100,nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     * */
    protected $slug;
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
     * Set abuse_entity
     *
     * @return Incident
     */
    public function setAbuseEntity($abuse_entity = null) {
        $this->abuse_entity = $abuse_entity;

        return $this;
    }

    /**
     * Get abuse_entity
     *
     */
    public function getAbuseEntity() {
        return $this->abuse_entity;
    }

    /**
     * Get abuse_entity
     *
     */
    public function getNetworkAdmin() {
        return $this->abuse_entity;
    }

    /**
     * Set network_entity
     *
     * @return Incident
     */
    public function setNetworkEntity($network_entity = null) {
        $this->network_entity = $network_entity;

        return $this;
    }

    /**
     * Get network_entity
     *
     */
    public function getNetworkEntity() {
        return $this->network_entity;
    }

    /**
     * Set startAddress
     *
     * @param string $startAddress
     *
     * @return ExternalIncident
     */
    public function setStartAddress($startAddress) {
        $this->start_address = $startAddress;

        return $this;
    }

    /**
     * Get startAddress
     *
     * @return string
     */
    public function getStartAddress() {
        return $this->start_address;
    }

    /**
     * Set endAddress
     *
     * @param string $endAddress
     *
     * @return ExternalIncident
     */
    public function setEndAddress($endAddress) {
        $this->end_address = $endAddress;

        return $this;
    }

    /**
     * Get endAddress
     *
     * @return string
     */
    public function getEndAddress() {
        return $this->end_address;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return ExternalIncident
     */
    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Set networkAdminEmails
     *
     * @param array $networkAdminEmails
     *
     * @return ExternalIncident
     */
    public function setAbuseEntityEmails($abuse_entity_emails) {
        $this->abuse_entity_emails = $abuse_entity_emails;

        return $this;
    }

    /**
     * Get networkAdminEmails
     *
     * @return array
     */
    public function getAbuseEntityEmails() {
        return $this->abuse_entity_emails;
    }

    /**
     * Get abuse_entity_emails
     *
     * @return array
     */
    public function getEmails() {
        return $this->abuse_entity_emails;
    }

}
