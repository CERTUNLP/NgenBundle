<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Api\Network;

use CertUnlp\NgenBundle\Controller\Api\ApiController;
use CertUnlp\NgenBundle\Entity\Network\NetworkEntity;
use CertUnlp\NgenBundle\Service\Api\Handler\NetworkEntityHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;

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
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return array
     */
    public function getAction(ParamFetcherInterface $paramFetcher)
    {
        return null;
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="List all academic unit networkentity.",
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset from which to start listing academic unit network_entity.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="How many academic unit network_entity to return.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     * @FOS\Get("/networks/entities")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing academic unit network_entity.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many academic unit network_entity to return.")
     * @FOS\View(
     *  templateVar="network_entitys"
     * )
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return View
     */
    public function getNetworkEntitysAction(ParamFetcherInterface $paramFetcher): View
    {
        return $this->getAll($paramFetcher);
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
     * @param NetworkEntity $network_entity
     * @return View
     * @FOS\View(
     *  templateVar="network_entity"
     * )
     * @ParamConverter("network_entity", class="CertUnlpNgenBundle:NetworkEntity")
     * @FOS\Get("/networks/entities/{slug}")
     */
    public function getNetworkEntityAction(NetworkEntity $network_entity): View
    {
        return $this->response([$network_entity]);
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
     * @FOS\Patch("/networks/entities/{slug}")
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
     * @FOS\Patch("/networks/entities/{slug}")
     * @param Request $request the request object
     * @param NetworkEntity $network_entity
     * @return View
     *
     */
    public function patchNetworkEntityBySlugAction(Request $request, NetworkEntity $network_entity): View
    {
        return $this->patch($request, $network_entity);
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
     * @param NetworkEntity $network_entity
     * @return View
     * @FOS\Patch("/networks/entities/{slug}/activate")
     */
    public function patchNetworkEntityActivateAction(Request $request, NetworkEntity $network_entity): View
    {
        return $this->activate($request, $network_entity);
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
     * @param NetworkEntity $network_entity
     * @return View
     * @FOS\Patch("/networks/entities/{slug}/desactivate")
     */
    public function patchNetworkEntityDesactivateAction(Request $request, NetworkEntity $network_entity): View
    {
        return $this->desactivate($request, $network_entity);
    }

}
