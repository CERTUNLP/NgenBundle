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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Network\Network;
use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Entity\Network\NetworkEntity;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author demyen
 */
interface NetworkInterface
{

    /**
     * Constructor
     */
    public function __construct();

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Network
     */
    public function setIsActive(bool $isActive);

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function isActive();

    /**
     * Set networkAdmin
     *
     * @param NetworkAdmin $networkAdmin
     * @return Network
     */
    public function setNetworkAdmin(NetworkAdmin $networkAdmin = null);

    /**
     * Get networkAdmin
     *
     * @return NetworkAdmin
     */
    public function getNetworkAdmin();

    /**
     * Set networkEntity
     *
     * @param NetworkEntity $networkEntity
     * @return Network
     */
    public function setNetworkEntity(NetworkEntity $networkEntity = null);

    /**
     * Get networkEntity
     *
     * @return NetworkEntity
     */
    public function getNetworkEntity();

    /**
     * Add incidents
     *
     * @param Incident $incidents
     * @return Network
     */
    public function addIncident(Incident $incidents);

    /**
     * Remove incidents
     *
     * @param Incident $incidents
     */
    public function removeIncident(Incident $incidents);

    /**
     * Get incidents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIncidents();

    /**
     * Set numericIp
     *
     * @param integer $numericIp
     * @return Network
     */
    public function setNumericIpV4(int $numericIp);

    /**
     * Get numericIp
     *
     * @return integer
     */
    public function getNumericIpV4();

    /**
     * Set numericIpMask
     *
     * @param integer $numericIpMask
     * @return Network
     */
    public function setNumericIpV4Mask(int $numericIpMask);

    /**
     * Get numericIpMask
     *
     * @return integer
     */
    public function getNumericIpV4Mask();

    public function equals(Network $other);
}
