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

use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentPriorityController extends AbstractFOSRestController
{
    /**
     * List all incident priorities.
     *
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
     *
     *
     * @FOS\Get("/priorities")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident priorities.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many incident priorities to return.")
     *
     * @FOS\View(
     *  templateVar="incident_priorities"
     * )
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getIncidentPrioritiesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.incident.priority.api.controller');
    }

    /**
     * Gets a Network for a given id.
     *
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
     *
     *
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
     * Create a Network from the submitted data.
     *
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
     *
     *
     * @FOS\Post("/priorities")
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postIncidentPriorityAction(Request $request)
    {
        return $this->getApiController()->post($request);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
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
     *
     * @FOS\Patch("/priorities/{id}")
     * @param Request $request the request object
     * @param IncidentPriority $incident_priority
     * @return FormTypeInterface|View
     *
     */
    public function patchIncidentPriorityBySlugAction(Request $request, IncidentPriority $incident_priority)
    {
        return $this->getApiController()->patch($request, $incident_priority);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
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
     *
     *
     *
     * @param Request $request the request object
     * @param IncidentPriority $incident_priority
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/priorities/{id}/activate")
     */
    public function patchIncidentPriorityActivateAction(Request $request, IncidentPriority $incident_priority)
    {
        return $this->getApiController()->activate($request, $incident_priority);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
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
     *
     *
     *
     * @param Request $request the request object
     * @param IncidentPriority $incident_priority
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/priorities/{id}/desactivate")
     */
    public function patchIncidentPriorityDesactivateAction(Request $request, IncidentPriority $incident_priority)
    {
        return $this->getApiController()->desactivate($request, $incident_priority);
    }

}
