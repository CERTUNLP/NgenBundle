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
     * Set ipMask
     *
     * @param string $ipMask
     * @return Network
     */
    public function setIpMask(string $ipMask);

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
     * @param \CertUnlp\NgenBundle\Entity\Network\NetworkAdmin $networkAdmin
     * @return Network
     */
    public function setNetworkAdmin(NetworkAdmin $networkAdmin = null);

    /**
     * Get networkAdmin
     *
     * @return \CertUnlp\NgenBundle\Entity\Network\NetworkAdmin
     */
    public function getNetworkAdmin();

    /**
     * Set networkEntity
     *
     * @param \CertUnlp\NgenBundle\Entity\Network\NetworkEntity $networkEntity
     * @return Network
     */
    public function setNetworkEntity(NetworkEntity $networkEntity = null);

    /**
     * Get networkEntity
     *
     * @return \CertUnlp\NgenBundle\Entity\Network\NetworkEntity
     */
    public function getNetworkEntity();

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
    public function setIp(string $ip): Network;

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
    public function setNumericIp(int $numericIp);

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
    public function setNumericIpMask(int $numericIpMask);

    /**
     * Get numericIpMask
     *
     * @return integer
     */
    public function getNumericIpMask();

    public function equals(NetworkInterface $other);
}
