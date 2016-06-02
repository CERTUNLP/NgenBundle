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

/**
 * Description of InternalIncident
 *
 * @author dam
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Entity\ExternalIncidentRepository")
 * @ORM\EntityListeners({ "CertUnlp\NgenBundle\Entity\Listener\ExternalIncidentListener" })
 */
class ExternalIncident extends Incident {

    /**
     * @ORM\Column(name="network", type="string",nullable=true)
     * @JMS\Expose
     */
    private $network;

    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $network_admin;

    /**
     * @ORM\Column(type="string",nullable=true)
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $network_entity;

    /**
     * Set network
     *
     * @return Incident
     */
    public function setNetwork(NetworkInterface $network = null) {
        $this->network = $network;

        return $this;
    }

    /**
     * Get network
     *
     */
    public function getNetwork() {
        return $this->network;
    }

    /**
     * Set network_admin
     *
     * @return Incident
     */
    public function setNetworkAdmin($network_admin = null) {
        $this->network_admin = $network_admin;

        return $this;
    }

    /**
     * Get network_admin
     *
     */
    public function getNetworkAdmin() {
        return $this->network_admin;
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

}
