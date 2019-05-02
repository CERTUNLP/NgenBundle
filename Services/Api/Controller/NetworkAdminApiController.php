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

use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NetworkAdminApiController extends ApiController
{

    /**
     * Create a Object from the submitted data.
     *
     * @param Request $request the request object
     *
     * @param $object
     * @return FormTypeInterface|View
     */
    public function doPatchAndReactivate(Request $request, $object)
    {
        try {
            $parameters = array_merge($request->request->all(), $request->files->all());;
            unset($parameters['_method'], $parameters['force_edit'], $parameters['reactivate']);

            $db_object = $this->findObjectBy($parameters);
            if (!$db_object) {
                if ($request->get('reactivate')) {
                    $object->setIsActive(TRUE);
                }
                if ($request->get('force_edit')) {
                    $statusCode = Response::HTTP_OK;

                    $object = $this->getCustomHandler()->patch($object, $parameters);
                } else {
                    $statusCode = Response::HTTP_CREATED;
                    $this->getCustomHandler()->desactivate($object);
                    unset($parameters['id']);
                    $object = $this->getCustomHandler()->post($parameters);
                }
            } else {
                $statusCode = Response::HTTP_OK;

                $this->getCustomHandler()->desactivate($object);
                $this->getCustomHandler()->activate($db_object);
                $object = $this->getCustomHandler()->patch($db_object, $parameters);
            }

            return $this->response([$object], $statusCode);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Create a Object from the submitted data.
     *
     * @param $params array
     *
     * @return NetworkAdmin entity
     */
    public function findObjectBy($params)
    {
        return $this->getCustomHandler()->get(['name' => $params['name']]);
    }
}
