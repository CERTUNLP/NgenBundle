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

use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentFeedController extends AbstractFOSRestController
{

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
     * List all incident feeds.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @FOS\Get("/feeds")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident feeds.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many incident feeds to return.")
     *
     * @FOS\View(
     *  templateVar="incident_feeds"
     * )
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getIncidentFeedsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.incident.feed.api.controller');
    }

    /**
     * Gets a Network for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a network admin for a given id",
     *   output = "CertUnlp\NgenBundle\Entity\Incident\IncidentFeed",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the network is not found"
     *   }
     * )
     *
     * @param IncidentFeed $incident_feed
     * @return IncidentFeed
     * @FOS\View(
     *  templateVar="incident_feed"
     * )
     * @ParamConverter("incident_feed", class="CertUnlpNgenBundle:Incident\IncidentFeed")
     * @FOS\Get("/feeds/{slug}")
     */
    public function getIncidentFeedAction(IncidentFeed $incident_feed)
    {
        return $incident_feed;
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
     * @FOS\Post("/feeds")
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postIncidentFeedAction(Request $request)
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
     * @FOS\Patch("/feeds/{slug}")
     * @param Request $request the request object
     * @param IncidentFeed $incident_feed
     * @return FormTypeInterface|View
     *
     */
    public function patchIncidentFeedAction(Request $request, IncidentFeed $incident_feed)
    {
        return $this->getApiController()->patch($request, $incident_feed, true);
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
     * @FOS\Patch("/feeds/{slug}")
     * @param Request $request the request object
     * @param IncidentFeed $incident_feed
     * @return FormTypeInterface|View
     *
     */
    public function patchIncidentFeedBySlugAction(Request $request, IncidentFeed $incident_feed)
    {
        return $this->getApiController()->patch($request, $incident_feed);
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
     * @param IncidentFeed $incident_feed
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/feeds/{slug}/activate")
     */
    public function patchIncidentFeedActivateAction(Request $request, IncidentFeed $incident_feed)
    {

        return $this->getApiController()->activate($request, $incident_feed);
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
     * @param IncidentFeed $incident_feed
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/feeds/{slug}/desactivate")
     */
    public function patchIncidentFeedDesactivateAction(Request $request, IncidentFeed $incident_feed)
    {

        return $this->getApiController()->desactivate($request, $incident_feed);
    }

}
