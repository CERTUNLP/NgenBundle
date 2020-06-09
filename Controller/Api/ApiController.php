<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Api;

use CertUnlp\NgenBundle\Exception\InvalidFormException;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
use CertUnlp\NgenBundle\Service\Api\Handler\Handler;
use CertUnlp\NgenBundle\Service\FormErrorsSerializer;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends AbstractFOSRestController
{
    /**
     * @var Handler
     */
    private $handler;
    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;
    /**
     * @var View
     */
    private $view;

    /**
     * @param Handler $handler
     * @param ViewHandlerInterface $viewHandler
     * @param View $view
     */
    public function __construct(Handler $handler, ViewHandlerInterface $viewHandler, View $view)
    {
        $this->handler = $handler;
        $this->viewHandler = $viewHandler;
        $this->view = $view;
    }

    /**
     * @param View $view
     * @return Response
     */
    public function handle($view = null)
    {
        $view = $view ?: $this->view;
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @return ViewHandlerInterface
     */
    public function getViewHandler(): ViewHandlerInterface
    {
        return $this->viewHandler;
    }

    /**
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     * @return array
     */
    public function getAll(Request $request, $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');

        return $this->getHandler()->all([], [], $limit, $offset);
    }

    /**
     * @return Handler
     */
    public function getHandler(): Handler
    {
        return $this->handler;
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function post(Request $request)
    {
        try {
            $entity_data = array_merge($request->request->all(), $request->files->all());

            $newObject = $this->getHandler()->post($entity_data);

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
     * @param Request $request
     * @param $entity
     * @param $state
     * @return View
     *
     */
    public function patchState(Request $request, $entity, $state)
    {

        try {
            $entity = $this->getHandler()->changeState(
                $entity, $state);
            return $this->response([$entity], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param Request $requesT
     * @param $entity
     * @param bool $reactivate
     * @return View
     *
     */
    public function patch(Request $request, EntityApiInterface $entity, bool $reactivate = false): ?View
    {
        try {
            if ($reactivate) {
                return $this->doPatchAndReactivate($request, $entity);
            }
            return $this->doPatch($request, $entity);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param Request $request
     * @param $entity
     * @return View
     */
    public function doPatchAndReactivate(Request $request, EntityApiInterface $entity): ?View
    {
        try {
            $parameters = array_merge($request->request->all(), $request->files->all());
            unset($parameters['_method'], $parameters['force_edit'], $parameters['reactivate']);

            $db_object = $this->getByDataIdentification($parameters);

            if (!$db_object) {
                if ($request->get('reactivate')) {
                    $entity->setActive(true);
                }
                if ($request->get('force_edit')) {
                    $statusCode = Response::HTTP_OK;

                    $entity = $this->getHandler()->patch($entity, $parameters);
                } else {
                    $statusCode = Response::HTTP_CREATED;

                    $this->getHandler()->desactivate($entity);
                    $entity = $this->getHandler()->post($parameters);
                }
            } else {
                $statusCode = Response::HTTP_OK;

                $this->getHandler()->desactivate($entity);
                $this->getHandler()->activate($db_object);
                $entity = $this->getHandler()->patch($db_object, $parameters);
            }

            return $this->response([$entity], $statusCode);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param array $parameters
     * @return EntityApiInterface|null
     */
    public function getByDataIdentification(array $parameters): ?EntityApiInterface
    {
        return $this->getHandler()->getByDataIdentification($parameters);
    }

    /**
     * @param Request $request
     * @param $entity
     * @return View
     *
     */
    public function doPatch(Request $request, EntityApiInterface $entity): ?View
    {
        try {
            $parameters = array_merge($request->request->all(), $request->files->all());

            unset($parameters['_method']);
            $entity = $this->getHandler()->patch(
                $entity, $parameters
            );
            return $this->response([$entity], Response::HTTP_OK);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param Request $request
     * @param EntityApiInterface $entity
     * @return View
     */
    public function delete(Request $request, EntityApiInterface $entity): ?View
    {
        try {

            $entity = $this->getHandler()->delete(
                $entity, $request->request->all()
            );

            return $this->response([$entity], Response::HTTP_OK);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param Request $request
     * @param $entity
     * @return View
     */
    public function desactivate(Request $request, EntityApiInterface $entity): ?View
    {
        try {
            $parameters = $request->request->all();
            unset($parameters['_method']);
            $entity = $this->getHandler()->desactivate(
                $entity, $parameters
            );
            return $this->response([$entity], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param Request $request
     * @param $entity
     * @return View
     */
    public function activate(Request $request, EntityApiInterface $entity): ?View
    {
        try {
            $parameters = $request->request->all();
            unset($parameters['_method']);
            $entity = $this->getHandler()->activate(
                $entity, $parameters
            );
            return $this->response([$entity], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        return $this->view;
    }

}
