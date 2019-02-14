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

use CertUnlp\NgenBundle\Entity\User;

class UserHandler extends Handler
{

    /**
     * Delete a Network.
     *
     * @return User
     */
    public function findOneRandom()
    {
        return $this->repository->findOneRandom();
    }

    /**
     * Delete a Network.
     *
     * @param $user
     * @param array $parameters
     *
     * @return void
     */
    public function prepareToDeletion($user, array $parameters = null)
    {
        $user->setEnabled(FALSE);
    }

    /**
     * Delete a Network.
     *
     * @param User $user
     * @param array $parameters
     *
     * @return User|object
     */
    public function desactivate($user, array $parameters = null)
    {
        return $this->delete($user, $parameters);
    }

    /**
     * Delete a Network.
     *
     * @param User $user
     * @param array $parameters
     *
     * @return User|object
     */
    public function activate($user, array $parameters = null)
    {
        $user->setEnabled(TRUE);
        return $this->patch($user, $parameters);
    }

    protected function checkIfExists($user, $method)
    {
        $userDB = $this->repository->findOneBy(['username' => $user->getUsername()]);

        if ($userDB && $method == 'POST') {
            if (!$userDB->isEnabled()) {
                $userDB->setEnabled(TRUE);
            }
            $user = $userDB;
        }
        return $user;
    }

    protected function createEntityInstance(array $params)
    {
        $user = new $this->entityClass();
        $user->setEnabled(true);
        $user->setApiKey(sha1($user->getUsername() . time() . $user->getSalt()));
        return $user;
    }
}
