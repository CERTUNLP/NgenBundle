<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Model;

use CertUnlp\NgenBundle\Model\IncidentInterface;
use CertUnlp\NgenBundle\Entity\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\AcademicUnit;
use CertUnlp\NgenBundle\Entity\Network;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author demyen
 */
interface NetworkInterface {

    /**
     * Set ipMask
     *
     * @param string $ipMask
     * @return Network
     */
    public function setIpMask($ipMask);

    /**
     * Get ipMask
     *
     * @return string 
     */
    public function getIpMask();

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Network
     */
    public function setIsActive($isActive);

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive();

    /**
     * Set networkAdmin
     *
     * @param \CertUnlp\NgenBundle\Entity\NetworkAdmin $networkAdmin
     * @return Network
     */
    public function setNetworkAdmin(NetworkAdmin $networkAdmin = null);

    /**
     * Get networkAdmin
     *
     * @return \CertUnlp\NgenBundle\Entity\NetworkAdmin 
     */
    public function getNetworkAdmin();

    /**
     * Set academicUnit
     *
     * @param \CertUnlp\NgenBundle\Entity\AcademicUnit $academicUnit
     * @return Network
     */
    public function setAcademicUnit(AcademicUnit $academicUnit = null);

    /**
     * Get academicUnit
     *
     * @return \CertUnlp\NgenBundle\Entity\AcademicUnit 
     */
    public function getAcademicUnit();

    /**
     * Constructor
     */
    public function __construct();

    /**
     * Add incidents
     *
     * @param \CertUnlp\NgenBundle\Model\IncidentInterface $incidents
     * @return Network
     */
    public function addIncident(IncidentInterface $incidents);

    /**
     * Remove incidents
     *
     * @param \CertUnlp\NgenBundle\Model\IncidentInterface $incidents
     */
    public function removeIncident(IncidentInterface $incidents);

    /**
     * Get incidents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIncidents();

    /**
     * Set ip
     *
     * @param string $ip
     * @return Network
     */
    public function setIp($ip);

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp();

    /**
     * Set numericIp
     *
     * @param integer $numericIp
     * @return Network
     */
    public function setNumericIp($numericIp);

    /**
     * Get numericIp
     *
     * @return integer 
     */
    public function getNumericIp();

    /**
     * Set numericIpMask
     *
     * @param integer $numericIpMask
     * @return Network
     */
    public function setNumericIpMask($numericIpMask);

    /**
     * Get numericIpMask
     *
     * @return integer 
     */
    public function getNumericIpMask();

    public function equals(NetworkInterface $other);
}
