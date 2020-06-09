<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Api\Incident;

use CertUnlp\NgenBundle\Controller\Api\ApiController;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Service\Api\Handler\IncidentTypeHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentTypeController extends ApiController
{
    /**
     * IncidentTypeController constructor.
     * @param IncidentTypeHandler $handler
     * @param ViewHandlerInterface $viewHandler
     * @param View $view
     */
    public function __construct(IncidentTypeHandler $handler, ViewHandlerInterface $viewHandler, View $view)
    {
        parent::__construct($handler, $viewHandler, $view);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Get status.",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the apikey is not found"
     *     )
     * )
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return array
     */
    public function getAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return null;
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="List all incident types.",
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset from which to start listing incident types.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="How many incident types to return.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident types.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many incident types to return.")
     *
     * @FOS\View(
     *  templateVar="incident_types"
     * )
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return array
     */
    public function getTypesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getAll($request, $paramFetcher);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Gets a network admin for a given id",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the network is not found"
     *     )
     * )
     * @param IncidentType $incident_type
     * @return IncidentType
     * @FOS\View(
     *  templateVar="incident_type"
     * )
     */
    public function getTypeAction(IncidentType $incident_type)
    {
        return $incident_type;
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Creates a new network from the submitted data.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="formData",
     *         description="",
     *         required=false,
     *         type="object (NetworkType)"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @FOS\Post("/types")
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postIncidentTypeAction(Request $request)
    {
        return $this->post($request);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @FOS\Patch("/types/{slug}")
     * @param Request $request the request object
     * @param IncidentType $incident_type
     * @return FormTypeInterface|View
     *
     */
    public function patchIncidentTypeAction(Request $request, IncidentType $incident_type)
    {
        return $this->patch($request, $incident_type, true);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @FOS\Patch("/types/{slug}")
     * @param Request $request the request object
     * @param IncidentType $incident_type
     * @return FormTypeInterface|View
     *
     */
    public function patchIncidentTypeBySlugAction(Request $request, IncidentType $incident_type)
    {
        return $this->patch($request, $incident_type, true);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @param Request $request the request object
     * @param IncidentType $incident_type
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/types/{slug}/activate")
     */
    public function patchIncidentTypeActivateAction(Request $request, IncidentType $incident_type)
    {
        return $this->activate($request, $incident_type);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @param Request $request the request object
     * @param IncidentType $incident_type
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/types/{slug}/desactivate")
     */
    public function patchIncidentTypeDesactivateAction(Request $request, IncidentType $incident_type)
    {
        return $this->desactivate($request, $incident_type);
    }

}
