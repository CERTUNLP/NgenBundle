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

use CertUnlp\NgenBundle\Model\EntityApiInterface;

abstract class NetworkElementHandler extends Handler
{
    /**
     * {@inheritDoc}
     */
    public function getByParamIdentification(array $parameters): ?EntityApiInterface
    {
        $parameters = $this->getParamIdentificationArray($parameters);
        return $this->getRepository()->findOneByAddress($parameters['address']);
    }

    /**
     * {@inheritDoc}
     */
    public function getParamIdentificationArray(array $parameters): array
    {
        return ['address' => $parameters['address']];
    }
}
