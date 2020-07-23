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
     * @var bool
     */
    private $editable;

    /**
     * @param Handler $handler
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(Handler $handler, ViewHandlerInterface $viewHandler)
    {
        $this->handler = $handler;
        $this->viewHandler = $viewHandler;
        $this->editable = false;
    }

    /**
     * @return ViewHandlerInterface
     */
    public function getViewHandler(): ViewHandlerInterface
    {
        return $this->viewHandler;
    }

    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return View
     */
    public function getAll(ParamFetcherInterface $paramFetcher): View
    {
        try {
            $offset = (int)$paramFetcher->get('offset');
            $limit = (int)$paramFetcher->get('limit');
            $objects = $this->getHandler()->all([], null, $limit, $offset);
            return $this->response([$objects], Response::HTTP_OK);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @return Handler
     */
    public function getHandler(): Handler
    {
        return $this->handler;
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @return View
     */
    public function response(array $data = array(), int $statusCode = Response::HTTP_CREATED, array $headers = array()): View
    {
        $this->getView()->setData($data);
        $this->getView()->setStatusCode($statusCode);
        $this->getView()->setHeaders($headers);
        $this->getView()->getContext()->setGroups(['read']);
        $this->getView()->getContext()->enableMaxDepth();
        return $this->getView();
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        if (!$this->view) {
            $this->view = View::create();
        }
        return $this->view;
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
     * @param array $objects
     * @return View
     */
    public function responseWrapper(array $objects): View
    {
        try {
            if ($objects) {
                return $this->response([$objects], Response::HTTP_OK);
            }
            return $this->response([], Response::HTTP_NOT_FOUND);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param array $parameters
     * @return View
     */
    public function getOne(array $parameters): View
    {
        try {
            $object = $this->getHandler()->getByParamIdentification($parameters);
            if ($object) {
                return $this->response([$object], Response::HTTP_OK);
            }
            return $this->response([], Response::HTTP_NOT_FOUND);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function post(Request $request): View
    {
        try {
            $parameters = array_merge($request->request->all(), $request->files->all());
            $entity = $this->getHandler()->post($parameters);
            return $this->response([$entity]);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param Request $request
     * @param EntityApiInterface $entity
     * @return View
     */
    public function patch(Request $request, EntityApiInterface $entity): View
    {
        try {
            $parameters = array_merge($request->request->all(), $request->files->all());
            unset($parameters['_method']);
            if ($request->get('force_edit') || $this->isEditable()) {
                $entity = $this->getHandler()->patch($entity, $parameters);
                return $this->response([$entity], Response::HTTP_OK);
            }
            return $this->response(['errors' => '', 'code' => Response::HTTP_FORBIDDEN, 'message' => 'editing not enabled. please use the "force_edit" field.'], Response::HTTP_FORBIDDEN);

        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @return bool
     */
    public function isEditable(): bool
    {
        return $this->editable;
    }

    /**
     * @param bool $editable
     * @return ApiController
     */
    public function setEditable(bool $editable): ApiController
    {
        $this->editable = $editable;
        return $this;
    }

    /**
     * @param array $parameters
     * @return EntityApiInterface|null
     */
    public function getByParamIdentification(array $parameters): ?EntityApiInterface
    {
        return $this->getHandler()->getByParamIdentification($parameters);
    }

    /**
     * @param EntityApiInterface $entity
     * @return View
     */
    public function delete(EntityApiInterface $entity): View
    {
        try {
            $entity = $this->getHandler()->delete($entity);
            return $this->response([$entity], Response::HTTP_OK);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param EntityApiInterface $entity
     * @return View
     */
    public function desactivate(EntityApiInterface $entity): View
    {
        try {
            $entity = $this->getHandler()->desactivate($entity);
            return $this->response([$entity], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @param EntityApiInterface $entity
     * @return View
     */
    public function activate(EntityApiInterface $entity): View
    {
        try {
            $entity = $this->getHandler()->activate($entity);
            return $this->response([$entity], Response::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

}
