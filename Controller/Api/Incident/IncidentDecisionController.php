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
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Entity\Network\Network;
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
     * @param IncidentType $type
     * @param IncidentFeed $feed
     * @param Network $ip_v4
     * @param Network|null $ip_v6
     * @param Network|null $domains
     * @return IncidentDecision
     * @FOS\View(
     *  templateVar="incident_decision"
     * )
     * @FOS\Get("/decisions/{type}/{feed}/{domains}", name="_domain",requirements={"domains"="^(?:[-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,6}$"} )
     * @FOS\Get("/decisions/{type}/{feed}/{ip_v4}", name="_ip_v4",  requirements={"ip_v4"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$"} )
     * @FOS\Get("/decisions/{type}/{feed}/{ip_v6}", name="_ip_v6",  requirements={"ip_v6"="^(::|(([a-fA-F0-9]{1,4}):){7}(([a-fA-F0-9]{1,4}))|(:(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){1,6}:)|((([a-fA-F0-9]{1,4}):)(:([a-fA-F0-9]{1,4})){1,6})|((([a-fA-F0-9]{1,4}):){2}(:([a-fA-F0-9]{1,4})){1,5})|((([a-fA-F0-9]{1,4}):){3}(:([a-fA-F0-9]{1,4})){1,4})|((([a-fA-F0-9]{1,4}):){4}(:([a-fA-F0-9]{1,4})){1,3})|((([a-fA-F0-9]{1,4}):){5}(:([a-fA-F0-9]{1,4})){1,2}))$"} )
     * @FOS\Get("/decisions/{type}/{feed}" )
     * @ParamConverter("domains", class="CertUnlp\NgenBundle\Entity\Network\Network", options={"repository_method" = "findOneByStringAddress", "domains"="address"},isOptional=true)
     * @ParamConverter("ip_v4", class="CertUnlp\NgenBundle\Entity\Network\Network", options={"repository_method" = "findOneByStringAddress", "ip_v4"="address"},isOptional=true)
     * @ParamConverter("ip_v6", class="CertUnlp\NgenBundle\Entity\Network\Network", options={"repository_method" = "findOneByStringAddress", "ip_v6"="address"},isOptional=true)
     */
    public function getIncidentDecisionAction(IncidentType $type, IncidentFeed $feed, Network $ip_v4 = null, Network $ip_v6 = null, Network $domains = null)
    {
        return $this->get('cert_unlp.ngen.incident.decision.handler')->getByNetwork($type, $feed, $ip_v4 ?? $ip_v6 ?? $domains);
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
