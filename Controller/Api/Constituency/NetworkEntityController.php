<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Api\Constituency;

use CertUnlp\NgenBundle\Controller\Api\ApiController;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkEntity;
use CertUnlp\NgenBundle\Form\Constituency\NetworkEntityType;
use CertUnlp\NgenBundle\Service\Api\Handler\Constituency\NetworkEntityHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NetworkEntityController extends ApiController
{
    /**
     * NetworkEntityController constructor.
     * @param NetworkEntityHandler $handler
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(NetworkEntityHandler $handler, ViewHandlerInterface $viewHandler)
    {
        parent::__construct($handler, $viewHandler);
    }

    /**
     * @Operation(
     *     tags={"Network entities"},
     *     summary="Removes a network entity",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=NetworkEntity::class, groups={"api"}))
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
     * @FOS\Delete("/networks/entities/{id}", requirements={"id" = "\d+"})
     * @FOS\Delete("/networks/entities/{slug}", name="_slug")
     * @param NetworkEntity $incident_state
     * @return View
     */
    public function deleteNetworkEntityAction(NetworkEntity $incident_state): View
    {
        return $this->delete($incident_state);
    }

    /**
     * @Operation(
     *     tags={"Network entities"},
     *     summary="List all network entities",
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
     *    @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=NetworkEntity::class, groups={"api"}))
     *          )
     *     ),
     * )
     * @FOS\Get("/networks/entities")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing academic unit network_entity.")
     * @FOS\QueryParam(name="limit", requirements="\d+", strict=true, default="100", description="How many academic unit network_entity to return.")
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return View
     */
    public function getNetworkEntitysAction(ParamFetcherInterface $paramFetcher): View
    {
        return $this->getAll($paramFetcher);
    }

    /**
     * @Operation(
     *     tags={"Network entities"},
     *     summary="Gets a network entity for a given id",
     *    @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=NetworkEntity::class, groups={"api"}))
     *          )
     *     ),
     *      @SWG\Response(
     *         response="404",
     *         description="Returned when the incident is not found",
     *          @SWG\schema(
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
     *     )
     * )
     * @param NetworkEntity $network_entity
     * @return View
     * @FOS\Get("/networks/entities/{slug}", name="_slug")
     * @FOS\Get("/networks/entities/{id}")
     */
    public function getNetworkEntityAction(NetworkEntity $network_entity): View
    {
        return $this->response([$network_entity], Response::HTTP_OK);
    }

    /**
     * @Operation(
     *     tags={"Network entities"},
     *     summary="Creates a new network entity from the submitted data.",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=NetworkEntityType::class, groups={"api"})
     *     ),
     *    @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=NetworkEntity::class, groups={"api"}))
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
     * @FOS\Post("/networks/entities")
     * @param Request $request the request object
     * @return View
     */
    public function postNetworkEntityAction(Request $request): View
    {
        return $this->post($request);
    }

    /**
     * @Operation(
     *     tags={"Network entities"},
     *     summary="Update existing entity from the submitted data",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=NetworkEntityType::class, groups={"api"})
     *     ),
     *    @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=NetworkEntity::class, groups={"api"}))
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
     * @FOS\Patch("/networks/entities/{id}")
     * @FOS\Patch("/networks/entities/{slug}", name="_slug")
     * @param Request $request the request object
     * @param NetworkEntity $network_entity
     * @return View
     *
     */
    public function patchNetworkEntityAction(Request $request, NetworkEntity $network_entity): View
    {
        return $this->patch($request, $network_entity, true);
    }

    /**
     * @Operation(
     *     tags={"Network entities"},
     *     summary="Activates an existing entity",
     *    @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=NetworkEntity::class, groups={"api"}))
     *          )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @param NetworkEntity $network_entity
     * @return View
     * @FOS\Patch("/networks/entities/{slug}/activate", name="_slug")
     * @FOS\Patch("/networks/entities/{id}/activate")
     */
    public function patchNetworkEntityActivateAction(NetworkEntity $network_entity): View
    {
        return $this->activate($network_entity);
    }

    /**
     * @Operation(
     *     tags={"Network entities"},
     *     summary="Desactivates an existing entity",
     *    @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=NetworkEntity::class, groups={"api"}))
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
     * @param NetworkEntity $network_entity
     * @return View
     * @FOS\Patch("/networks/entities/{slug}/desactivate", name="_slug")
     * @FOS\Patch("/networks/entities/{id}/desactivate")
     */
    public function patchNetworkEntityDesactivateAction(NetworkEntity $network_entity): View
    {
        return $this->desactivate($network_entity);
    }

}
