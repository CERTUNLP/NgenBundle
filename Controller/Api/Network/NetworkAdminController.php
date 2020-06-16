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
use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Service\Api\Handler\NetworkAdminHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NetworkAdminController extends ApiController
{
    /**
     * NetworkAdminController constructor.
     * @param NetworkAdminHandler $handler
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(NetworkAdminHandler $handler, ViewHandlerInterface $viewHandler)
    {
        parent::__construct($handler, $viewHandler);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="List all network admins.",
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset from which to start listing network admins.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="How many network admins to return.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     * @FOS\Get("/networks/admins")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing network admins.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many network admins to return.")
     * @FOS\View(
     *  templateVar="network_admins"
     * )
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return View
     */
    public function getNetworkAdminsAction(ParamFetcherInterface $paramFetcher): View
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
     * @param NetworkAdmin $network_admin
     * @return View
     * @FOS\View(
     *  templateVar="network_admin"
     * )
     * @ParamConverter("network_admin", class="CertUnlpNgenBundle:NetworkAdmin")
     * @FOS\Get("/networks/admins/{id}", requirements={"id" = "\d+"})
     */
    public function getNetworkAdminAction(NetworkAdmin $network_admin): View
    {
        return $this->response([$network_admin], Response::HTTP_OK);
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
     * @FOS\Post("/networks/admins")
     * @param Request $request the request object
     * @return View
     */
    public function postNetworkAdminAction(Request $request): View
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
     * @FOS\Patch("/networks/admins/{id}", requirements={"id" = "\d+"})
     * @param Request $request the request object
     * @param NetworkAdmin $network_admin
     * @return View
     */
    public function patchNetworkAdminAction(Request $request, NetworkAdmin $network_admin): View
    {
        return $this->patch($request, $network_admin, true);
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
     * @FOS\Patch("/networks/admins/{slug}")
     * @param Request $request the request object
     * @param NetworkAdmin $network_admin
     * @return View
     */
    public function patchNetworkAdminBySlugAction(Request $request, NetworkAdmin $network_admin): View
    {
        return $this->patch($request, $network_admin, true);
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
     * @param NetworkAdmin $network_admin
     * @return View
     * @FOS\Patch("/networks/admins/{id}/activate")
     */
    public function patchNetworkAdminActivateAction(Request $request, NetworkAdmin $network_admin): View
    {
        return $this->activate($request, $network_admin);
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
     * @param NetworkAdmin $network_admin
     * @return View
     * @FOS\Patch("/networks/admins/{id}/desactivate")
     */
    public function patchNetworkAdminDesactivateAction(Request $request, NetworkAdmin $network_admin): View
    {
        return $this->desactivate($request, $network_admin);
    }

}
