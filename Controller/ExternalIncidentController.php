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

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CertUnlp\NgenBundle\Entity\ExternalIncident;
use CertUnlp\NgenBundle\Entity\IncidentState;
use CertUnlp\NgenBundle\Entity\IncidentType;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class ExternalIncidentController extends FOSRestController
{

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
    public function getExternalReportHtmlAction(IncidentType $incidentType)
    {

        return $this->getApiController()->reportHtmlAction($incidentType->getSlug());
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.incident.external.api.controller');
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
     * @param ExternalIncident $incident
     * @return array
     */
    public function getExternalReportMailAction(ExternalIncident $incident)
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
     * @FOS\QueryParam(name="limit", requirements="\d+", default="5", description="How many incidents to return.")
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getExternalsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    /**
     * Get single ExternalIncident.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "CertUnlp\NgenBundle\Entity\Incident",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the incident is not found"
     *   }
     * )
     *
     * @param ExternalIncident $incident
     * @return ExternalIncident
     *
     */
    public function getExternalAction(ExternalIncident $incident)
    {
        return $incident;
    }

    /**
     * Create a ExternalIncident from the submitted data.
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
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postExternalAction(Request $request)
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
     * @param ExternalIncident $incident
     * @return FormTypeInterface|View
     * @FOS\Put("/externals/{slug}")
     */
    public function putExternalAction(Request $request, ExternalIncident $incident)
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
     *
     * @param Request $request the request object
     * @param ExternalIncident $incident
     * @param IncidentState $state
     * @return FormTypeInterface|View
     *
     */
    public function patchExternalStateAction(Request $request, ExternalIncident $incident, IncidentState $state)
    {

        return $this->getApiController()->patchState($request, $incident, $state);
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
     *
     * @param Request $request the request object
     * @param ExternalIncident $incident
     * @param IncidentState $state
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/externals/{slug}/states/{state}")
     */
    public function patchExternalStateWithParamsAction(Request $request, ExternalIncident $incident, IncidentState $state)
    {
        return $this->getApiController()->patchState($request, $incident, $state);
    }

    /**
     * Get single .
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "CertUnlp\NgenBundle\Entity\Incident",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the incident is not found"
     *   }
     * )
     *
     * @param ExternalIncident $incident
     * @return ExternalIncident
     *
     * @Fos\Get("/externals/{slug}")
     */
    public function getExternalWithParamsAction(ExternalIncident $incident)
    {
        return $incident;
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
     *
     * @param Request $request the request object
     * @param ExternalIncident $incident
     * @return FormTypeInterface|View
     *
     */
    public function patchExternalAction(Request $request, ExternalIncident $incident)
    {
        return $this->getApiController()->patch($request, $incident);
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
     *
     * @param Request $request the request object
     * @param ExternalIncident $incident
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/externals/{slug}")
     */
    public function patchExternalWithParamsAction(Request $request, ExternalIncident $incident)
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
     *
     * @FOS\View(
     *  template = "CertUnlpNgenBundle:Incident:editIncident.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param ExternalIncident $incident the incident id
     *
     * @return FormTypeInterface|View
     *
     */
    public function deleteExternalAction(Request $request, ExternalIncident $incident)
    {
        return $this->getApiController()->delete($request, $incident);
    }

}
