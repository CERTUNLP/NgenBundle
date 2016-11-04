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
use CertUnlp\NgenBundle\Form\IncidentStateType;
use CertUnlp\NgenBundle\Entity\IncidentState;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as FOS;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CertUnlp\NgenBundle\Exception\InvalidFormException;

class IncidentStateController extends FOSRestController {

    public function getApiController() {

        return $this->container->get('cert_unlp.ngen.incident.state.api.controller');
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
     * List all incident states.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @FOS\Get("/states")

     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident states.")
     * @FOS\QueryParam(name="limit", requirements="\d+", default="5", description="How many incident states to return.")
     *
     * @FOS\View(
     *  templateVar="incident_states"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getIncidentStatesAction(Request $request, ParamFetcherInterface $paramFetcher) {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    /**
     * Gets a Network for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a network admin for a given id",
     *   output = "CertUnlp\NgenBundle\Entity\IncidentState",
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
     *  templateVar="incident_state"
     * )
     * @throws NotFoundHttpException when network not exist
     * @ParamConverter("incident_state", class="CertUnlpNgenBundle:IncidentState")
     * @FOS\Get("/states/{slug}")
     *         
     */
    public function getIncidentStateAction(IncidentState $incident_state) {
        return $incident_state;
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
     * @FOS\Post("/states")

     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postIncidentStateAction(Request $request) {
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
     * @FOS\Patch("/states/{slug}")
     * @param Request $request the request object
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     */
    public function patchIncidentStateAction(Request $request, IncidentState $incident_state) {
        return $this->getApiController()->patch($request, $incident_state, true);
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
     * @FOS\Patch("/states/{slug}")
     * @param Request $request the request object
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     */
    public function patchIncidentStateBySlugAction(Request $request, IncidentState $incident_state) {
        return $this->getApiController()->patch($request, $incident_state);
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
     * @FOS\Patch("/states/{slug}/activate")
     */
    public function patchIncidentStateActivateAction(Request $request, IncidentState $incident_state) {

        return $this->getApiController()->activate($request, $incident_state);
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
     * @FOS\Patch("/states/{slug}/desactivate")
     */
    public function patchIncidentStateDesactivateAction(Request $request, IncidentState $incident_state) {

        return $this->getApiController()->desactivate($request, $incident_state);
    }

}
