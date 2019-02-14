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

use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Network\Host\Host;

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
    public function findByAddress(string $address): ?Host
    {
        return $this->repository->findByAddress(['address' => $address]);
    }

    /**
     * @param $host Host
     * @param $method
     * @return object|null
     */
    protected function checkIfExists($host, $method)
    {
        $hostDB = $this->repository->findByAddress(['address' => $host->getAddress()]);

        if ($hostDB && $method === 'POST') {
            if (!$hostDB->getIsActive()) {
                $hostDB->setIsActive(TRUE);
            }
            $host = $hostDB;
        }
        return $host;
    }

    protected function createEntityInstance(array $params)
    {
        $entity_class_instance = new $this->entityClass($params['address']);

        return $entity_class_instance->guessAddress($entity_class_instance->getIpV4() ?? $entity_class_instance->getIpV6() ?? $entity_class_instance->getDomain());
    }


}
