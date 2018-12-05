<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Handler;

use CertUnlp\NgenBundle\Entity\Incident\Host\Host;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;

class HostHandler extends Handler
{

    /**
     * Delete a Network.
     *
     * @param IncidentFeed $host
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($host, array $parameters = null)
    {
        $host->setIsActive(false);
    }

    /**
     * Get a Network.
     *
     * @param string $address
     * @return Host
     */
    public function findByIpV4(string $address): ?Host
    {

        return $this->repository->findOneBy(['ip_v4' => $address]);
    }

    /**
     * @param $host Host
     * @param $method
     * @return object|null
     */
    protected function checkIfExists($host, $method)
    {
        $hostDB = $this->repository->findOneBy(['ip_v4' => $host->getIpV4()]);

        if ($hostDB && $method === 'POST') {
            if (!$hostDB->getIsActive()) {
                $hostDB->setIsActive(TRUE);
            }
            $host = $hostDB;
        }
        return $host;
    }
}
