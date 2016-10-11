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

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormTypeInterface;
use CertUnlp\NgenBundle\Exception\InvalidFormException;

class ApiController {

    public function __construct($handler, $viewHandler, $view) {
        $this->custom_handler = $handler;
        $this->viewHandler = $viewHandler;
        $this->view = $view;
    }

    public function getCustomHandler() {
        return $this->custom_handler;
    }

    public function getView() {
        return $this->view;
    }

    /**
     * @param View $view
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($view = null) {
        $view = $view ? $view : $this->view;
        return $this->viewHandler->handle($view);
    }

    /**
     * @param  array $data
     * @return View
     */
    public function setData(array $data) {
        return $this->view->setData($data);
    }

    /**
     * @param  array $data
     * @return View
     */
    public function setStatusCode($statusCode) {
        return $this->view->setStatusCode($statusCode);
    }

    /**
     * @param  array $data
     * @return View
     */
    public function response(array $parameters = array(), $statusCode = Response::HTTP_CREATED, array $headers = array()) {
        $this->setData($parameters);
        $this->setStatusCode($statusCode);
        return $this->view;
    }

    /**
     * Get all objects.
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getAll(Request $request, $paramFetcher) {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->getCustomHandler()->all([], [], $limit, $offset);
    }

    /**
     * Create a Object from the submitted data.
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function post(Request $request) {
        //TODO: refactoring aca o algo, poqnomegusta
        try {
            $object_data = array_merge($request->request->all(), $request->files->all());

            $newObject = $this->getCustomHandler()->post($object_data);

            return $this->response([$newObject], Response::HTTP_CREATED);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update existing object from the submitted data or create a new object at a specific location.
     *
     * @param Request $request the request object
     * @param int     $id      the object id
     *
     * @return FormTypeInterface|View
     * @throws NotFoundHttpException when object not exist
     */
    public function put(Request $request, $object) {
        try {
            if (!($object = $this->getCustomHandler()->get($id))) {
                $statusCode = Response::HTTP_CREATED;
                $object = $this->getCustomHandler()->post(
                        $request->request->all()
                );
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;
                $object = $this->getCustomHandler()->put(
                        $object, $request->request->all()
                );
            }
            return $this->response([$object], $statusCode);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing object from the submitted data or create a new object at a specific location.
     *
     * @param Request $request the request object
     * @param int     $id      the object id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when object not exist
     */
    public function patchState(Request $request, $object, $state) {

        try {
            $object = $this->getCustomHandler()->changeState(
                    $object, $state);

            return $this->response([$object], Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * Update existing object from the submitted data or create a new object at a specific location.
     *
     * @param Request $request the request object
     * @param int     $id      the object id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when object not exist
     */
    public function patch(Request $request, $object) {
        try {
            $parameters = $request->request->all();
            unset($parameters['_method']);
            $object = $this->getCustomHandler()->patch(
                    $object, $parameters
            );
            return $this->response([$object], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing object from the submitted data or create a new object at a specific location.
     *
     *
     * @param Request $request the request object
     * @param int     $object      the object id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when object not exist
     */
    public function delete(Request $request, $object) {
        try {

            $object = $this->getCustomHandler()->delete(
                    $object, $request->request->all()
            );

            return $this->response([$object], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function desactivate(Request $request, $object) {

        try {
            $parameters = $request->request->all();
            unset($parameters['_method']);
            $object = $this->getCustomHandler()->desactivate(
                    $object, $parameters
            );
            return $this->response([$object], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Delete a Network.
     *
     * @param NetworkInterface $network
     * @param array $parameters
     *
     * @return NetworkInterface
     */
    public function activate(Request $request, $object) {
         try {
            $parameters = $request->request->all();
            unset($parameters['_method']);
            $object = $this->getCustomHandler()->activate(
                    $object, $parameters
            );
            return $this->response([$object], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

}
