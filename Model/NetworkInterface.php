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
use Doctrine\Common\Collections\Collection;

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
    public function setIpMask(string $ipMask): Network;

    /**
     * Get ipMask
     *
     * @return string
     */
    public function getIpMask(): string;

    /**
     * Set isActive
     *
     * @param bool $isActive
     * @return Network
     */
    public function setIsActive(bool $isActive): Network;

    /**
     * Get isActive
     *
     * @return bool
     */
    public function isActive(): bool;

    /**
     * Set networkAdmin
     *
     * @param NetworkAdmin $networkAdmin
     * @return Network
     */
    public function setNetworkAdmin(NetworkAdmin $networkAdmin = null): Network;

    /**
     * Get networkAdmin
     *
     * @return NetworkAdmin
     */
    public function getNetworkAdmin(): NetworkAdmin;

    /**
     * Set networkEntity
     *
     * @param NetworkEntity $networkEntity
     * @return Network
     */
    public function setNetworkEntity(NetworkEntity $networkEntity = null): Network;

    /**
     * Get networkEntity
     *
     * @return NetworkEntity
     */
    public function getNetworkEntity(): NetworkEntity;

    /**
     * Add incidents
     *
     * @param IncidentInterface $incidents
     * @return Network
     */
    public function addIncident(IncidentInterface $incidents): Network;

    /**
     * Remove incidents
     *
     * @param IncidentInterface $incidents
     * @return bool
     */
    public function removeIncident(IncidentInterface $incidents): bool;

    /**
     * Get incidents
     *
     * @return Collection
     */
    public function getIncidents(): Collection;

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
    public function getIp(): string;

    /**
     * Set numericIp
     *
     * @param int $numericIp
     * @return Network
     */
    public function setNumericIp(int $numericIp): Network;

    /**
     * Get numericIp
     *
     * @return int
     */
    public function getNumericIp(): int;

    /**
     * Set numericIpMask
     *
     * @param int $numericIpMask
     * @return Network
     */
    public function setNumericIpMask(int $numericIpMask): Network;

    /**
     * Get numericIpMask
     *
     * @return int
     */
    public function getNumericIpMask(): int;

    /**
     * @param NetworkInterface $other
     * @return bool
     */
    public function equals(NetworkInterface $other): bool;
}
