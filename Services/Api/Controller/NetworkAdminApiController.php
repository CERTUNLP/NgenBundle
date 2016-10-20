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

class NetworkAdminApiController extends ApiController {

    /**
     * Create a Object from the submitted data.
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function patch(Request $request, $network_admin) {
        try {
            $parameters = $request->request->all();
            unset($parameters['_method'], $parameters['force_edit'], $parameters['reactivate']);

            $DBnetwork_admin = $this->getCustomHandler()->get(['name' => $request->request->get('name'), 'email' => $request->request->get('email')]);

            if (!$DBnetwork_admin) {
                if ($request->get('reactivate')) {
                    $network_admin->setIsActive(TRUE);
                }
                if ($request->get('force_edit')) {
                    $statusCode = Response::HTTP_NO_CONTENT;

                    $network_admin = $this->getCustomHandler()->patch($network_admin, $parameters);
                } else {
                    $statusCode = Response::HTTP_CREATED;
                    $this->getCustomHandler()->desactivate($network_admin);
                    $network_admin = $this->getCustomHandler()->post($parameters);
                }
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;

                $this->getCustomHandler()->desactivate($network_admin);
                $this->getCustomHandler()->activate($DBnetwork_admin);
                $network_admin = $this->getCustomHandler()->patch($DBnetwork_admin, $parameters);
            }

            return $this->response([$network_admin], $statusCode);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

}
