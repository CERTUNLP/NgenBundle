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
use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use CertUnlp\NgenBundle\Service\Api\Handler\IncidentPriorityHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentPriorityController extends ApiController
{
    /**
     * IncidentPriorityController constructor.
     * @param IncidentPriorityHandler $handler
     * @param ViewHandlerInterface $viewHandler
     * @param View $view
     */
    public function __construct(IncidentPriorityHandler $handler, ViewHandlerInterface $viewHandler, View $view)
    {
        parent::__construct($handler, $viewHandler, $view);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="List all incident priorities.",
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset from which to start listing incident priorities.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="How many incident priorities to return.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     * @FOS\Get("/priorities")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident priorities.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many incident priorities to return.")
     * @FOS\View(
     *  templateVar="incident_priorities"
     * )
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getIncidentPrioritiesAction(Request $request, ParamFetcherInterface $paramFetcher)
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
     * @param IncidentPriority $incident_priority
     * @return IncidentPriority
     * @FOS\View(
     *  templateVar="incident_priority"
     * )
     * @ParamConverter("incident_priority", class="CertUnlp\NgenBundle\Entity\Incident\IncidentPriority")
     * @FOS\Get("/priorities/{id}")
     */
    public function getIncidentPriorityAction(IncidentPriority $incident_priority)
    {
        return $incident_priority;
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
     * @FOS\Post("/priorities")
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postIncidentPriorityAction(Request $request)
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
     * @FOS\Patch("/priorities/{id}")
     * @param Request $request the request object
     * @param IncidentPriority $incident_priority
     * @return FormTypeInterface|View
     */
    public function patchIncidentPriorityBySlugAction(Request $request, IncidentPriority $incident_priority)
    {
        return $this->patch($request, $incident_priority);
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
     * @param IncidentPriority $incident_priority
     * @return FormTypeInterface|View
     * @FOS\Patch("/priorities/{id}/activate")
     */
    public function patchIncidentPriorityActivateAction(Request $request, IncidentPriority $incident_priority)
    {
        return $this->activate($request, $incident_priority);
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
     * @param IncidentPriority $incident_priority
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/priorities/{id}/desactivate")
     */
    public function patchIncidentPriorityDesactivateAction(Request $request, IncidentPriority $incident_priority)
    {
        return $this->desactivate($request, $incident_priority);
    }

}
