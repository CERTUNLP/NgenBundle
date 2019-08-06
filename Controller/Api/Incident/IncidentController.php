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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Network\Address\Address;
use CertUnlp\NgenBundle\Entity\Network\Host\Host;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentController extends FOSRestController
{

    /**
     * Get single Incident.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "CertUnlp\NgenBundle\Entity\Incident\Incident",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the incident is not found"
     *   }
     * )
     *
     * @param Incident $incident
     * @return Incident
     * @FOS\Get("/incidents/{id}", name="_id",requirements={"id"="\d+"}))
     */
    public function getIncidentAction(Incident $incident)
    {
        return $incident;
    }

    /**
     * Create a Incident from the submitted data.
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
    public function postIncidentAction(Request $request)
    {

        return $this->getApiController($request->get('ip'))->post($request);
    }

    public function getApiController()
    {
        return $this->container->get('cert_unlp.ngen.incident.internal.api.controller');
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
    public function getIncidentsAction(Request $request, ParamFetcherInterface $paramFetcher): array
    {

        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    /**
     * Update existing incident from the submitted data or create a new incident at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\IncidentType",
     *   statusCodes = {
     *     201 = "Returned when the Incident is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param Incident $incident
     * @return FormTypeInterface|View
     * @FOS\Put("/incidents/{id}", name="_id",requirements={"id"="\d+"}))
     * @FOS\Put("/incidents/{slug}")
     */
    public function putIncidentsAction(Request $request, Incident $incident)
    {
        return $this->getApiController($incident)->put($request, $incident);
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
     * @param Incident $incident
     * @param IncidentState $state
     * @return FormTypeInterface|View
     * @FOS\Patch("/incidents/{id}/states/{state}", name="_id",requirements={"id"="\d+"}))
     * @FOS\Patch("/incidents/{slug}/states/{state}")
     *
     */
    public function patchIncidentStateAction(Request $request, Incident $incident, IncidentState $state)
    {
        return $this->getApiController($incident)->patchState($request, $incident, $state);
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
     * @param Incident $incident
     * @return FormTypeInterface|View
     * @FOS\Patch("/incidents/{id}", name="_id",requirements={"id"="\d+"}))
     * @FOS\Patch("/incidents/{slug}")
     */
    public function patchIncidentAction(Request $request, Incident $incident)
    {
        return $this->getApiController($incident)->patch($request, $incident);
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
     * @param Incident $incident the incident id
     *
     * @return FormTypeInterface|View
     * @FOS\Delete("/incidents/{id}", name="_id",requirements={"id"="\d+"}))
     * @FOS\Delete("/incidents/{slug}")
     */
    public function deleteIncidentAction(Request $request, Incident $incident)
    {
        return $this->getApiController($incident)->delete($request, $incident);
    }

    public function getPriority()
    {
        return $this->getDoctrine()->getRepository(IncidentPriority::class)->find($this->getImpact(), $this->getUrgency());
    }

    private function isInternal(string $ip)
    {
        return $this->get('cert_unlp.ngen.network.handler')->getByHostAddress($ip);
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
     * @FOS\QueryParam(name="from", requirements="\d+", description="Minor Date")
     * @FOS\QueryParam(name="to", requirements="\d+", description="Mayor Date")
     * @FOS\View(
     *  templateVar="incidents"
     * )
     * @param Request $request the request object
     * @param Date $from
     * @param Date $to
     *
     * @return array
     */
    public function getIncidentsBeetwenDatesAction(Request $request, Date $from, Date $to): array
    {

        ##return null
        return $this->getApiController()->getAll($request, $from,$to);
    }

    /**
     * Get single Incident using type and address.
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "CertUnlp\NgenBundle\Entity\Incident\Incident",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the incident is not found",
     *     409 = "More than one incident"
     *   }
     * )
     * @FOS\View(
     *  templateVar="incident_existing"
     * )
     * @param IncidentType $type
     * @return Incident
     * @FOS\Get("/incidents/search/{type}")
     * @FOS\Get("/incidents/search/{type}/{domains}", name="_domain",requirements={"domains"="^(?:[-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,6}$"} )
     * @FOS\Get("/incidents/search/{type}/{ip_v4}", name="_ip_v4",  requirements={"ip_v4"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$"} )
     * @FOS\Get("/incidents/search/{type}/{ip_v6}", name="_ip_v6",  requirements={"ip_v6"="^(::|(([a-fA-F0-9]{1,4}):){7}(([a-fA-F0-9]{1,4}))|(:(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){1,6}:)|((([a-fA-F0-9]{1,4}):)(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){2}(:([a-fA-F0-9]{1,4})){1,5})|((([a-fA-F0-9]{1,4}):){3}(:([a-fA-F0-9]{1,4})){1,4})|((([a-fA-F0-9]{1,4}):){4}(:([a-fA-F0-9]{1,4})){1,3})|((([a-fA-F0-9]{1,4}):){5}(:([a-fA-F0-9]{1,4})){1,2}))$"} )
     */

    public function getIncidentSearchAction(IncidentType $type, $ip_v4 = null, host $ip_v6 = null, Host $domains = null)
    {
        return $this->getDoctrine()->getRepository(Incident::class)->findByTypeAndAddress( $type, $ip_v4 ?? $ip_v6 ?? $domains);
    }

}
