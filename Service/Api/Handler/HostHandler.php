<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler;

use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Network\Host\Host;
use CertUnlp\NgenBundle\Repository\HostRepository;
use Doctrine\Common\Persistence\ObjectRepository;

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
     * @param $host Host
     * @param $method string
     * @return object|null| Host
     */
    protected function checkIfExists($host, $method)
    {
        $hostDB = $this->getRepository()->findOneByAddress($host->getAddress());

        if ($hostDB && $method === 'POST') {
            if (!$hostDB->isActive()) {
                $hostDB->setIsActive(TRUE);
            }
            $host = $hostDB;
        }
        return $host;
    }

    protected function createEntityInstance(array $params)
    {
        return new $this->entityClass($params['address']);
    }


}
