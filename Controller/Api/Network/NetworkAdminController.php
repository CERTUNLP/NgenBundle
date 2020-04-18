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

use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class NetworkAdminController extends AbstractFOSRestController
{

    /**
     * List all networks.
     *
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
     *
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getAction(Request $request, ParamFetcherInterface $paramFetcher)
    {

        return null;
    }

    /**
     * List all network admins.
     *
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
     *
     *
     * @FOS\Get("/networks/admins")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing network admins.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many network admins to return.")
     *
     * @FOS\View(
     *  templateVar="network_admins"
     * )
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getNetworkAdminsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.network.admin.api.controller');
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
     * @param NetworkAdmin $network_admin
     * @return NetworkAdmin
     * @FOS\View(
     *  templateVar="network_admin"
     * )
     * @ParamConverter("network_admin", class="CertUnlpNgenBundle:NetworkAdmin")
     * @FOS\Get("/networks/admins/{id}", requirements={"id" = "\d+"})
     */
    public function getNetworkAdminAction(NetworkAdmin $network_admin)
    {
        return $network_admin;
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
     * @FOS\Post("/networks/admins")
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postNetworkAdminAction(Request $request)
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
     * @FOS\Patch("/networks/admins/{id}", requirements={"id" = "\d+"})
     * @param Request $request the request object
     * @param NetworkAdmin $network_admin
     * @return FormTypeInterface|View
     *
     */
    public function patchNetworkAdminAction(Request $request, NetworkAdmin $network_admin)
    {
        return $this->getApiController()->patch($request, $network_admin, true);
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
     * @FOS\Patch("/networks/admins/{slug}")
     * @param Request $request the request object
     * @param NetworkAdmin $network_admin
     * @return FormTypeInterface|View
     *
     */
    public function patchNetworkAdminBySlugAction(Request $request, NetworkAdmin $network_admin)
    {
        return $this->getApiController()->patch($request, $network_admin, true);
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
     * @param NetworkAdmin $network_admin
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/networks/admins/{id}/activate")
     */
    public function patchNetworkAdminActivateAction(Request $request, NetworkAdmin $network_admin)
    {

        return $this->getApiController()->activate($request, $network_admin);
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
     * @param NetworkAdmin $network_admin
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/networks/admins/{id}/desactivate")
     */
    public function patchNetworkAdminDesactivateAction(Request $request, NetworkAdmin $network_admin)
    {

        return $this->getApiController()->desactivate($request, $network_admin);
    }

}
