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
    public function patchNetworkAction(Request $request, Network $network) {
        try {

            $parameters = $request->request->all();
            unset($parameters['_method'], $parameters['force_edit'], $parameters['reactivate']);


            $DBnetwork = $this->container->get('cert_unlp.ngen.network.handler')->get(['ip' => $request->request->get('ip'), 'ipMask' => $request->request->get('ipMask')]);

            if ($request->get('reactivate')) {
                $network->setIsActive(TRUE);
            }

            if (!$network->equals($DBnetwork)) {
                if ($request->get('force_edit')) {
                    $statusCode = Response::HTTP_NO_CONTENT;

                    $network = $this->container->get('cert_unlp.ngen.network.handler')->patch($network, $parameters);
                } else {
                    $statusCode = Response::HTTP_CREATED;
                    $this->container->get('cert_unlp.ngen.network.handler')->delete($network);
                    $network = $this->container->get('cert_unlp.ngen.network.handler')->post($parameters);
                }
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;

                $network = $this->container->get('cert_unlp.ngen.network.handler')->patch($network, $parameters);
            }

            $routeOptions = array(
                'ip' => $network->getIp(),
                'ipMask' => $network->getIpMask(),
                '_format' => $request->get('_format')
            );
            return $this->routeRedirectView('api_1_get_network', $routeOptions, $statusCode);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

}
