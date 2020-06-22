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
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use CertUnlp\NgenBundle\Form\IncidentPriorityType;
use CertUnlp\NgenBundle\Service\Api\Handler\IncidentPriorityHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IncidentPriorityController extends ApiController
{
    /**
     * IncidentPriorityController constructor.
     * @param IncidentPriorityHandler $handler
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(IncidentPriorityHandler $handler, ViewHandlerInterface $viewHandler)
    {
        parent::__construct($handler, $viewHandler);
    }

    /**
     * @Operation(
     *     tags={"Incident priorities"},
     *     summary="List all incident priorities.",
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset from which to start listing",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="How many entities to return",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentPriority::class, groups={"api"}))
     *          )
     *     ),
     * )
     * @FOS\Get("/priorities")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident priorities.")
     * @FOS\QueryParam(name="limit", requirements="\d+", strict=true, default="100", description="How many incident priorities to return.")
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return View
     */
    public function getIncidentPrioritiesAction(ParamFetcherInterface $paramFetcher): View
    {
        return $this->getAll($paramFetcher);
    }

    /**
     * @Operation(
     *     tags={"Incident priorities"},
     *     summary="Gets a priority admin for a given id",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentPriority::class, groups={"api"}))
     *          )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the network is not found"
     *     )
     * )
     * @FOS\Get("/priorities/{id}", name="_id")
     * @FOS\Get("/priorities/{urgency}/{impact}")
     * @param IncidentPriority $incident_priority
     * @return View
     */
    public function getIncidentPriorityAction(IncidentPriority $incident_priority): View
    {
        try {
            return $this->response([$incident_priority], Response::HTTP_OK);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @Operation(
     *     tags={"Incident priorities"},
     *     summary="Removes a priority",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentPriority::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Delete("/priorities/{id}", name="_id", requirements={"id"="\d+"}))
     * @FOS\Delete("/priorities/{urgency}/{impact}")
     * @param IncidentPriority $incident_priority
     * @return View
     */
    public function deletePriorityAction(IncidentPriority $incident_priority): View
    {
        return $this->delete($incident_priority);
    }

    /**
     * @Operation(
     *     tags={"Incident priorities"},
     *     summary="Creates a new priority from the submitted data.",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentPriorityType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentPriority::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Post("/priorities")
     * @param Request $request the request object
     * @return View
     */
    public function postIncidentPriorityAction(Request $request): View
    {
        return $this->post($request);
    }

    /**
     * @Operation(
     *     tags={"Incident priorities"},
     *     summary="Update existing priority from the submitted data",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentPriorityType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentPriority::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Patch("/priorities/{id}", name="_id")
     * @FOS\Patch("/priorities/{urgency}/{impact}")
     * @param Request $request the request object
     * @param IncidentPriority $incident_priority
     * @return View
     */
    public function patchIncidentPriorityAction(Request $request, IncidentPriority $incident_priority): View
    {
        return $this->patch($request, $incident_priority);
    }

    /**
     * @Operation(
     *     tags={"Incident priorities"},
     *     summary="Activates an existing priority",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentPriorityType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentPriority::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Patch("/priorities/{id}/activate", name="_id")
     * @FOS\Patch("/priorities/{urgency}/{impact}/activate")
     * @param IncidentPriority $incident_priority
     * @return View
     */
    public function patchIncidentPriorityActivateAction(IncidentPriority $incident_priority): View
    {
        return $this->activate($incident_priority);
    }

    /**
     * @Operation(
     *     tags={"Incident priorities"},
     *     summary="Desactivates an existing priority",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentPriorityType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentPriority::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Patch("/priorities/{id}/desactivate", name="_id")
     * @FOS\Patch("/priorities/{urgency}/{impact}/desactivate")
     * @param IncidentPriority $incident_priority
     * @return View
     */
    public function patchIncidentPriorityDesactivateAction(IncidentPriority $incident_priority): View
    {
        return $this->desactivate($incident_priority);
    }

}
