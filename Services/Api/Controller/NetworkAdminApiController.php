<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Controller;

use CertUnlp\NgenBundle\Entity\NetworkAdmin;

class NetworkAdminApiController extends ApiController
{

    /**
     * Create a Object from the submitted data.
     *
     * @param $params array
     *
     * @return NetworkAdmin entity
     */
    public function findObjectBy($params)
    {
        return $this->getCustomHandler()->get(['name' => $params['name'], 'email' => $params['email']]);
    }

}
