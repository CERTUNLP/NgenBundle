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

class HostHandler extends Handler
{

    public function getEntityIdentificationArray(Entity $entity): array
    {
        return ['address' => $entity->getAddress()];
    }

//    /**
//     * @param Entity $entity
//     * @return Entity
//     */
//    public function getIfExists(Entity $entity): Entity
//    {
//        return $this->getRepository()->findOneByAddress($entity->getAddress());
//    }

//    private function createEntityInstance(array $params)
//    {
//        return new $this->entityClass($params['address']);
//    }


}
