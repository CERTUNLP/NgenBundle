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

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\User;

class UserHandler extends Handler
{


    /**
     * @param array $parameters
     * @return Entity| User
     */
    public function createEntityInstance(array $parameters = []): Entity
    {
        /** @var User $user */
        $user = parent::createEntityInstance($parameters);
        $user->setEnabled(true);
        $user->setApiKey(sha1($user->getUsername() . time() . $user->getSalt()));
        return $user;
    }

    /**
     * @param Entity | User $entity
     * @return array
     */
    public function getEntityIdentificationArray(Entity $entity): array
    {
        return ['username' => $entity->getUsername()];
    }

}
