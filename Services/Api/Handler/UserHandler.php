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

class UserHandler extends Handler {

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function findOneRandom() {
        return $this->repository->findOneRandom();
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function prepareToDeletion($user, array $parameters = null) {
        $user->setEnabled(FALSE);
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function desactivate($network, array $parameters = null) {

        return $this->delete($network, $parameters);
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function activate($network, array $parameters = null) {
        $network->setEnabled(TRUE);
        return $this->patch($network, $parameters);
    }

    protected function checkIfExists($user, $method) {
        $userDB = $this->repository->findOneBy(['username' => $user->getUsername()]);

        if ($userDB && $method == 'POST') {
            if (!$userDB->isEnabled()) {
                $userDB->setEnabled(TRUE);
            }
            $user = $userDB;
        }
        return $user;
    }

}
