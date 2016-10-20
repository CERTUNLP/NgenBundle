<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use CertUnlp\NgenBundle\Form\NetworkAdminType;
use CertUnlp\NgenBundle\Entity\NetworkAdmin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as FOS;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CertUnlp\NgenBundle\Exception\InvalidFormException;

class NetworkAdminController extends FOSRestController {

    public function getApiController() {

        return $this->container->get('cert_unlp.ngen.network.admin.api.controller');
    }

    /**
     * List all networks.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getAction(Request $request, ParamFetcherInterface $paramFetcher) {

        return null;
    }

    /**
     * List all network admins.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @FOS\Get("/networks/admins")

     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing network admins.")
     * @FOS\QueryParam(name="limit", requirements="\d+", default="5", description="How many network admins to return.")
     *
     * @FOS\View(
     *  templateVar="network_admins"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getNetworkAdminsAction(Request $request, ParamFetcherInterface $paramFetcher) {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    /**
     * Gets a Network for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a network admin for a given id",
     *   output = "CertUnlp\NgenBundle\Entity\NetworkAdmin",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the network is not found"
     *   }
     * )
     *
     * @param int     $id      the network id
     *
     * @return array
     * @FOS\View(
     *  templateVar="network_admin"
     * )
     * @throws NotFoundHttpException when network not exist
     * @ParamConverter("network_admin", class="CertUnlpNgenBundle:NetworkAdmin")
     * @FOS\Get("/networks/admins/{id}", requirements={"id" = "\d+"})
     *         
     */
    public function getNetworkAdminAction(NetworkAdmin $network_admin) {
        return $network_admin;
    }

    /**
     * Create a Network from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new network from the submitted data.",
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @FOS\Post("/networks/admins")

     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postNetworkAdminAction(Request $request) {
        return $this->getApiController()->post($request);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @FOS\Patch("/networks/admins/{id}", requirements={"id" = "\d+"})
     * @param Request $request the request object
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     */
    public function patchNetworkAdminAction(Request $request, NetworkAdmin $network_admin) {
        return $this->getApiController()->patch($request, $network_admin);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @FOS\Patch("/networks/admins/{slug}")
     * @param Request $request the request object
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     */
    public function patchNetworkAdminBySlugAction(Request $request, NetworkAdmin $network_admin) {
        return $this->getApiController()->patch($request, $network_admin);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     * @FOS\Patch("/networks/admins/{id}/activate")
     */
    public function patchNetworkAdminActivateAction(Request $request, NetworkAdmin $network_admin) {

        return $this->getApiController()->activate($request, $network_admin);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     * @FOS\Patch("/networks/admins/{id}/desactivate")
     */
    public function patchNetworkAdminDesactivateAction(Request $request, NetworkAdmin $network_admin) {

        return $this->getApiController()->desactivate($request, $network_admin);
    }

}
