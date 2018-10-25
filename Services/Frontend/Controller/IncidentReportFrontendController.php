<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Frontend\Controller;

use Symfony\Component\HttpFoundation\Request;

class IncidentReportFrontendController extends FrontendController
{

    public function newEntity(Request $request, $default_type = '')
    {
        return array('form' => $this->formFactory->create(new $this->entityType())->createView(), 'method' => 'POST', 'default_type' => $default_type);
    }

    public function editEntity($object, $default_type = '')
    {

        return array('form' => $this->formFactory->create(new $this->entityType(), $object)->createView(), 'method' => 'patch', 'default_type' => $default_type);
    }

}
