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

use CertUnlp\NgenBundle\Exception\InvalidFormException;
use CertUnlp\NgenBundle\Services\Api\Handler\Handler;
use CertUnlp\NgenBundle\Services\FormErrorsSerializer;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController
{

    private $custom_handler;
    private $viewHandler;
    private $view;

    public function __construct(Handler $handler, ViewHandler $viewHandler, View $view)
    {
        $this->custom_handler = $handler;
        $this->viewHandler = $viewHandler;
        $this->view = $view;
    }

    public function getView()
    {
        return $this->view;
    }

    /**
     * @param View $view
     *
     * @return Response
     */
    public function handle($view = null)
    {
        $view = $view ?: $this->view;
        return $this->viewHandler->handle($view);
    }

    /**
     * Get all objects.
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getAll(Request $request, $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');

        return $this->getCustomHandler()->all([], [], $limit, $offset);
    }

    /**
     * @return mixed
     */
    public function getCustomHandler()
    {
        return $this->custom_handler;
    }

    /**
     * Create a Object from the submitted data.
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function post(Request $request)
    {
        try {
            $object_data = array_merge($request->request->all(), $request->files->all());

            $newObject = $this->getCustomHandler()->post($object_data);

            return $this->response([$newObject]);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param array $parameters
     * @param int $statusCode
     * @param array $headers
     * @return View
     */
    public function response(array $parameters = array(), int $statusCode = Response::HTTP_CREATED, array $headers = array())
    {
        $this->setData($parameters);
        $this->setStatusCode($statusCode);
        return $this->view;
    }

    /**
     * @param array $data
     * @return View
     */
    public function setData(array $data)
    {
        return $this->view->setData($data);
    }

    /**
     * @param $statusCode
     * @return View
     */
    public function setStatusCode($statusCode)
    {
        return $this->view->setStatusCode($statusCode);
    }

    /**
     * @param InvalidFormException $exception
     * @return View
     */
    public function responseError(InvalidFormException $exception): View
    {
        $form_serializer = new FormErrorsSerializer();

        return $this->response(['errors' => $form_serializer->serializeFormErrors($exception->getForm(), true, true), 'code' => Response::HTTP_BAD_REQUEST, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update existing object from the submitted data or create a new object at a specific location.
     *
     * @param Request $request the request object
     * @param $object
     * @return FormTypeInterface|View
     */
    public function put(Request $request, $object)
    {
//        try {
//            if (!($object = $this->getCustomHandler()->get($id))) {
//                $statusCode = Response::HTTP_CREATED;
//                $object = $this->getCustomHandler()->post(
//                    $request->request->all()
//                );
//            } else {
//                $statusCode = Response::HTTP_NO_CONTENT;
//                $object = $this->getCustomHandler()->put(
//                    $object, $request->request->all()
//                );
//            }
//            return $this->response([$object], $statusCode);
//        } catch (InvalidFormException $exception) {
//
//            return $exception->getForm();
//        }
    }

    /**
     * Update existing object from the submitted data or create a new object at a specific location.
     *
     * @param Request $request the request object
     * @param $object
     * @param $state
     * @return FormTypeInterface|View
     *
     */
    public function patchState(Request $request, $object, $state)
    {

        try {
            $object = $this->getCustomHandler()->changeState(
                $object, $state);

            return $this->response([$object], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
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
        try {
            if ($reactivate) {
                return $this->doPatchAndReactivate($request, $object);
            }
            return $this->doPatch($request, $object);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

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
     * Update existing object from the submitted data or create a new object at a specific location.
     *
     * @param Request $request the request object
     * @param $object
     * @return FormTypeInterface|View
     *
     */
    public function doPatch(Request $request, $object)
    {
        try {
            $parameters = array_merge($request->request->all(), $request->files->all());

            unset($parameters['_method']);
            $object = $this->getCustomHandler()->patch(
                $object, $parameters
            );
            return $this->response([$object], Response::HTTP_OK);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Update existing object from the submitted data or create a new object at a specific location.
     *
     *
     * @param Request $request the request object
     * @param object $object the object id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when object not exist
     */
    public function delete(Request $request, $object)
    {
        try {

            $object = $this->getCustomHandler()->delete(
                $object, $request->request->all()
            );

            return $this->response([$object], Response::HTTP_OK);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Delete a Network.
     *
     * @param Request $request
     * @param $object
     * @return View
     */
    public function desactivate(Request $request, $object)
    {

        try {
            $parameters = $request->request->all();
            unset($parameters['_method']);
            $object = $this->getCustomHandler()->desactivate(
                $object, $parameters
            );
            return $this->response([$object], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Delete a Network.
     *
     * @param Request $request
     * @param $object
     * @return View
     */
    public function activate(Request $request, $object)
    {
        try {
            $parameters = $request->request->all();
            unset($parameters['_method']);
            $object = $this->getCustomHandler()->activate(
                $object, $parameters
            );
            return $this->response([$object], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

}
