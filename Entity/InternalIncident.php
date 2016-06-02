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

use Doctrine\ORM\Mapping as ORM;
use CertUnlp\NgenBundle\Model\NetworkInterface;
use JMS\Serializer\Annotation as JMS;
use CertUnlp\NgenBundle\Entity\Incident;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of InternalIncident
 *
 * @author dam
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Entity\InternalIncidentRepository")
 * @ORM\EntityListeners({ "CertUnlp\NgenBundle\Entity\Listener\InternalIncidentListener" })

 * 
 */
class InternalIncident extends Incident {

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Model\NetworkInterface", inversedBy="incidents") 
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $network;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\NetworkAdmin", inversedBy="incidents")    
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $network_admin;

    /**
     * @ORM\ManyToOne(targetEntity="CertUnlp\NgenBundle\Entity\AcademicUnit", inversedBy="incidents") 
     * @JMS\Expose
     * @JMS\Groups({"api"})
     */
    private $academic_unit;

    /**
     * Set network
     *
     * @param \CertUnlp\NgenBundle\Model\NetworkInterface $network
     * @return Incident
     */
    public function setNetwork(NetworkInterface $network = null) {
        $this->network = $network;
        $this->setNetworkAdmin($network->getNetworkAdmin());
        $this->setAcademicUnit($network->getAcademicUnit());

        return $this;
    }

    /**
     * Get network
     *
     * @return \CertUnlp\NgenBundle\Model\NetworkInterface} 
     */
    public function getNetwork() {
        return $this->network;
    }

    /**
     * Set networkAdmin
     *
     * @param \CertUnlp\NgenBundle\Entity\NetworkAdmin $networkAdmin
     *
     * @return InternalIncident
     */
    public function setNetworkAdmin(\CertUnlp\NgenBundle\Entity\NetworkAdmin $networkAdmin = null) {
        $this->network_admin = $networkAdmin;

        return $this;
    }

    /**
     * Get networkAdmin
     *
     * @return \CertUnlp\NgenBundle\Entity\NetworkAdmin
     */
    public function getNetworkAdmin() {
        return $this->network_admin;
    }

    /**
     * Set academicUnit
     *
     * @param \CertUnlp\NgenBundle\Entity\AcademicUnit $academicUnit
     *
     * @return InternalIncident
     */
    public function setAcademicUnit(\CertUnlp\NgenBundle\Entity\AcademicUnit $academicUnit = null) {
        $this->academic_unit = $academicUnit;

        return $this;
    }

    /**
     * Get academicUnit
     *
     * @return \CertUnlp\NgenBundle\Entity\AcademicUnit
     */
    public function getAcademicUnit() {
        return $this->academic_unit;
    }

}
