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

use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentDecisionController extends FOSRestController
{
    /**
     * List all incident decisions.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @FOS\Get("/decisions")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident decisions.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many incident decisions to return.")
     *
     * @FOS\View(
     *  templateVar="incident_decisions"
     * )
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getIncidentDecisionsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.incident.decision.api.controller');
    }

    /**
     * Gets a Network for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a network admin for a given id",
     *   output = "CertUnlp\NgenBundle\Entity\Incident\IncidentDecision",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the network is not found"
     *   }
     * )
     *
     * @param IncidentDecision $incident_decision
     * @return IncidentDecision
     * @FOS\View(
     *  templateVar="incident_decision"
     * )
     * @ParamConverter("incident_decision", class="CertUnlpNgenBundle:IncidentDecision")
     * @FOS\Get("/decisions/{id}")
     */
    public function getIncidentDecisionAction(IncidentDecision $incident_decision)
    {
        return $incident_decision;
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
     * @FOS\Post("/decisions")
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postIncidentDecisionAction(Request $request)
    {
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
     * @FOS\Patch("/decisions/{id}")
     * @param Request $request the request object
     * @param IncidentDecision $incident_decision
     * @return FormTypeInterface|View
     *
     */
    public function patchIncidentDecisionAction(Request $request, IncidentDecision $incident_decision)
    {
        return $this->getApiController()->patch($request, $incident_decision, true);
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
     * @FOS\Patch("/decisions/{id}")
     * @param Request $request the request object
     * @param IncidentDecision $incident_decision
     * @return FormTypeInterface|View
     *
     */
    public function patchIncidentDecisionBySlugAction(Request $request, IncidentDecision $incident_decision)
    {
        return $this->getApiController()->patch($request, $incident_decision);
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
     * @param IncidentDecision $incident_decision
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/decisions/{id}/activate")
     */
    public function patchIncidentDecisionActivateAction(Request $request, IncidentDecision $incident_decision)
    {

        return $this->getApiController()->activate($request, $incident_decision);
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
     * @param IncidentDecision $incident_decision
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/decisions/{id}/desactivate")
     */
    public function patchIncidentDecisionDesactivateAction(Request $request, IncidentDecision $incident_decision)
    {

        return $this->getApiController()->desactivate($request, $incident_decision);
    }

}
