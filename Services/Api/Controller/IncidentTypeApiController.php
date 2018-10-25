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

use CertUnlp\NgenBundle\Entity\IncidentType;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentTypeApiController extends ApiController
{

    /**
     * Create a Object from the submitted data.
     *
     * @param $params array
     *
     * @return IncidentType entity
     */
    public function findObjectBy($params)
    {
        return $this->getCustomHandler()->get(['name' => $params['name']]);
    }

    /**
     * Update existing object from the submitted data or create a new object at a specific location.
     *
     * @param Request $request the request object
     * @param $object
     * @param bool $reactivate
     * @return FormTypeInterface|View
     *
     */
    public function patch(Request $request, $object, $reactivate = false)
    {
        return parent::patch($request, $object, $reactivate);
    }

}
