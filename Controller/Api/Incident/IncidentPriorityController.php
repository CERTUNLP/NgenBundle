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

use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentPriorityController extends FOSRestController
{
    /**
     * List all incident priorities.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @FOS\Get("/priorities")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident priorities.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many incident priorities to return.")
     *
     * @FOS\View(
     *  templateVar="incident_priorities"
     * )
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getIncidentPrioritiesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.incident.priority.api.controller');
    }

    /**
     * Gets a Network for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a network admin for a given id",
     *   output = "CertUnlp\NgenBundle\Entity\Incident\IncidentPriority",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the network is not found"
     *   }
     * )
     *
     * @param IncidentPriority $incident_priority
     * @return IncidentPriority
     * @FOS\View(
     *  templateVar="incident_priority"
     * )
     * @ParamConverter("incident_priority", class="CertUnlp\NgenBundle\Entity\Incident\IncidentPriority")
     * @FOS\Get("/priorities/{id}")
     */
    public function getIncidentPriorityAction(IncidentPriority $incident_priority)
    {
        return $incident_priority;
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
     * @FOS\Post("/priorities")
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postIncidentPriorityAction(Request $request)
    {
        return $this->getApiController()->post($request);
    }

    /**
     * Update existing priority from the submitted data or create a new priority at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\IncidentPriorityType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @FOS\Patch("/priorities/{impact}/{urgency}")
     * @param Request $request the request object
     * @param IncidentPriority $incident_priority
     * @return FormTypeInterface|View
     *
     */
    public function patchIncidentPriorityAction(Request $request, IncidentPriority $incident_priority)
    {
        return $this->getApiController()->patch($request, $incident_priority, true);
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
     * @FOS\Patch("/priorities/{id}")
     * @param Request $request the request object
     * @param IncidentPriority $incident_priority
     * @return FormTypeInterface|View
     *
     */
    public function patchIncidentPriorityBySlugAction(Request $request, IncidentPriority $incident_priority)
    {
        echo "die";
        return $this->getApiController()->patch($request, $incident_priority);
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
     * @param IncidentPriority $incident_priority
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/priorities/{id}/activate")
     */
    public function patchIncidentPriorityActivateAction(Request $request, IncidentPriority $incident_priority)
    {

        return $this->getApiController()->activate($request, $incident_priority);
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
     * @param IncidentPriority $incident_priority
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/priorities/{id}/desactivate")
     */
    public function patchIncidentPriorityDesactivateAction(Request $request, IncidentPriority $incident_priority)
    {

        return $this->getApiController()->desactivate($request, $incident_priority);
    }

}
