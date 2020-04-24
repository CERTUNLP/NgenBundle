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

use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;

class NetworkAdminHandler extends Handler
{

    /**
     * Delete a Network.
     *
     * @param NetworkAdmin $network_admin
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($network_admin, array $parameters = null)
    {
        $network_admin->setIsActive(FALSE);
    }

    protected function checkIfExists($network_admin, $method)
    {
        $network_adminDB = $this->repository->findOneBy(['id' => $network_admin->getId()]);

        if ($network_adminDB && $method === 'POST') {
            if (!$network_adminDB->getIsActive()) {
                $network_adminDB->setIsActive(TRUE);
            }
            $network_admin = $network_adminDB;
        }
        return $network_admin;
    }

    protected function createEntityInstance(array $params)
    {
        return new $this->entityClass();
    }
}
