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
use CertUnlp\NgenBundle\Entity\Incident\IncidentState;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
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
     * @FOS\Get("/incidents/{slug}")
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
        return $this->getApiController($request->get('hostAddress'))->post($request);
    }

    public function getApiController($hostAddress)
    {
        if (is_object($hostAddress) ? $hostAddress->isInternal() : $this->isInternal($hostAddress)) {
            return $this->container->get('cert_unlp.ngen.incident.internal.api.controller');
        } else {
            return $this->container->get('cert_unlp.ngen.incident.external.api.controller');
        }
    }

    private function isInternal(string $hostAddress)
    {
        return $this->get('cert_unlp.ngen.network.handler')->getByHostAddress($hostAddress);
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

}
