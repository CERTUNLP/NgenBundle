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

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use Symfony\Component\Security\Core\SecurityContext;
use CertUnlp\NgenBundle\Services\Api\Handler\Handler;

class NetworkAdminHandler extends Handler {

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network_admin
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function prepareToDeletion($network_admin, array $parameters = null) {
        $network_admin->setIsActive(FALSE);
    }

    protected function checkIfExists($network_admin, $method) {
        $network_adminDB = $this->repository->findOneBy(['name' => $network_admin->getName(), 'email' => $network_admin->getEmail()]);

        if ($network_adminDB && $method == 'POST') {
            if (!$network_adminDB->getIsActive()) {
                $network_adminDB->setIsActive(TRUE);
            }
            $network_admin = $network_adminDB;
        }
        return $network_admin;
    }

}
