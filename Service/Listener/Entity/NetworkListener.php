<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Listener\Entity;

use CertUnlp\NgenBundle\Entity\Constituency\NetworkElement\Network\Network;
use CertUnlp\NgenBundle\Repository\Constituency\NetworkElement\HostRepository;
use Doctrine\ORM\Mapping as ORM;


class NetworkListener
{

    /**
     * @var HostRepository
     */
    private $host_repository;

    public function __construct(HostRepository $host_repository)
    {
        $this->host_repository = $host_repository;
    }

    /** @ORM\PostLoad()
     * @param Network $network
     */
    public function postLoad(Network $network): void
    {
        if ($network->getIp()) {
            $network->guessAddress($network->getIp() . '/' . $network->getIpMask());
        } else {
            $network->guessAddress($network->getIp() ?? $network->getDomain());
        }
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @param Network $network
     */
    public function prePersistHandler(Network $network): void
    {
        $hosts = $this->getHostRepository()->findInRange($network->getAddressAndMask(), true);
        foreach ($hosts as $host) {
            $network->addHost($host);
        }
    }

    /**
     * @return HostRepository
     */
    public function getHostRepository(): HostRepository
    {
        return $this->host_repository;
    }

}
