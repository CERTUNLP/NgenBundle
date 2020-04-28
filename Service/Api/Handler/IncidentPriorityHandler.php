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

class IncidentPriorityHandler extends Handler
{
    /**
     * @inheritDoc
     */
    public function getEntityIdentificationArray(Entity $entity): array
    {
        return ['id' => $entity->getId()];
    }

}