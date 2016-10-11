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

class NetworkApiController extends ApiController {

    /**
     * Create a Object from the submitted data.
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function patch(Request $request, $network) {
        try {
            $parameters = $request->request->all();
            unset($parameters['_method'], $parameters['force_edit'], $parameters['reactivate']);

            $DBnetwork = $this->getCustomHandler()->get(['ip' => $request->request->get('ip'), 'ipMask' => $request->request->get('ipMask')]);

            if (!$DBnetwork) {
                if ($request->get('reactivate')) {
                    $network->setIsActive(TRUE);
                }
                if ($request->get('force_edit')) {
                    $statusCode = Response::HTTP_NO_CONTENT;

                    $network = $this->getCustomHandler()->patch($network, $parameters);
                } else {
                    $statusCode = Response::HTTP_CREATED;
                    $this->getCustomHandler()->desactivate($network);
                    $network = $this->getCustomHandler()->post($parameters);
                }
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;

                $this->getCustomHandler()->activate($DBnetwork);
                $network = $this->getCustomHandler()->patch($DBnetwork, $parameters);
            }

            return $this->response([$network], $statusCode);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

}
