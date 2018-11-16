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

use CertUnlp\NgenBundle\Entity\IncidentState;
use CertUnlp\NgenBundle\Entity\IncidentType;
use CertUnlp\NgenBundle\Entity\InternalIncident;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class InternalIncidentController extends FOSRestController
{

    /**
     * List all incidents.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
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
     * Prints a mail template for the given incident.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Prints a mail twig template for the given incident type.",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the incident is not found"
     *   }
     * )
     * @param IncidentType $incidentType
     * @return array
     */
    public function getInternalReportHtmlAction(IncidentType $incidentType)
    {

        return $this->getApiController()->reportHtmlAction($incidentType->getSlug());
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.incident.internal.api.controller');
    }

    /**
     * Prints a mail template for the given incident.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Prints a mail html template for the given incident.",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the incident is not found"
     *   }
     * )
     *
     * @Fos\View()
     *
     * @param InternalIncident $incident
     * @return array
     */
    public function getInternalReportMailAction(InternalIncident $incident)
    {

        return $this->getApiController()->reportMailAction($incident);
    }

    /**
     * List all incidents.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incidents.")
     * @FOS\QueryParam(name="limit", requirements="\d+", default="100", description="How many incidents to return.")
     * @FOS\View(
     *  templateVar="incidents"
     * )
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getInternalsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {

        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    /**
     * Get single InternalIncident.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "CertUnlp\NgenBundle\Entity\Incident",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the incident is not found"
     *   }
     * )
     * @FOS\View(
     *  templateVar="incident"
     * )
     * @param InternalIncident $incident
     * @return InternalIncident
     * @FOS\Get("/internals/{id}", name="api_2_get_internal_id",requirements={"id"="\d+"}))
     * @FOS\Get("/internals/{slug}")
     *
     */
    public function getInternalAction(InternalIncident $incident)
    {
        return $incident;
    }

    /**
     * Create a InternalIncident from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new incident from the submitted data.",
     *   input = "CertUnlp\NgenBundle\Form\IncidentType",
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @FOS\View(
     *  templateVar="incidents"
     * )
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postInternalAction(Request $request)
    {

        return $this->getApiController()->post($request);
    }

    /**
     * Update existing incident from the submitted data or create a new incident at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\IncidentType",
     *   statusCodes = {
     *     201 = "Returned when the IncidentInterface is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param InternalIncident $incident
     * @return FormTypeInterface|View
     * @FOS\View(
     *  templateVar="incidents"
     * )
     * @FOS\Put("/internals/{id}", name="api_2_put_internal_id",requirements={"id"="\d+"}))
     * @FOS\Put("/internals/{slug}")
     */
    public function putInternalAction(Request $request, InternalIncident $incident)
    {
        return $this->getApiController()->put($request, $incident);
    }

    /**
     * Update existing incident from the submitted data or create a new incident at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @FOS\View(
     *  templateVar="incidents"
     * )
     * @param Request $request the request object
     * @param InternalIncident $incident
     * @param IncidentState $state
     * @return FormTypeInterface|View
     * @FOS\Patch("/internals/{id}/states/{state}", name="api_2_patch_internal_state_id", requirements={"id"="\d+"})
     * @FOS\Patch("/internals/{slug}/states/{state}", requirements={"id"="\w+"})
     *
     */
    public function patchInternalStateAction(Request $request, InternalIncident $incident, IncidentState $state)
    {

        return $this->getApiController()->patchState($request, $incident, $state);
    }

    /**
     * Update existing incident from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\IncidentType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @FOS\View(
     *  templateVar="incidents"
     * )
     * @param Request $request the request object
     * @param InternalIncident $incident
     * @return FormTypeInterface|View
     * @FOS\Patch("/internals/{id}", name="api_2_get_internal_id",requirements={"id"="\d+"}))
     * @FOS\Patch("/internals/{slug}")
     *
     */
    public function patchInternalAction(Request $request, InternalIncident $incident)
    {
        return $this->getApiController()->patch($request, $incident);
    }

    /**
     * Update existing incident from the submitted data or create a new incident at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\IncidentType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @FOS\View(
     *  templateVar="incidents"
     * )
     * @param Request $request the request object
     * @param InternalIncident $incident the incident id
     *
     * @return FormTypeInterface|View
     * @FOS\Delete("/internals/{id}", name="api_2_get_internal_id",requirements={"id"="\d+"}))
     * @FOS\Delete("/internals/{slug}")
     *
     */
    public function deleteInternalAction(Request $request, InternalIncident $incident)
    {
        return $this->getApiController()->delete($request, $incident);
    }

}
