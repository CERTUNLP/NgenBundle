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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use CertUnlp\NgenBundle\Services\Api\Controller\ApiController;

class AcademicUnitApiController extends ApiController {

    /**
     * Create a Object from the submitted data.
     *
     * @param $params array
     *
     * @return Network entity
     */
    public function findObjectBy($params) {
        return $this->getCustomHandler()->get(['name' => $params['name']]);
    }

}
