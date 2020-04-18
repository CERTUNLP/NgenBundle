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
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentFeedController extends AbstractFOSRestController
{

    /**
     * List all networks.
     *
     * @Operation(
     *     tags={""},
     *     summary="Get status.",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the apikey is not found"
     *     )
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
     * @Operation(
     *     tags={""},
     *     summary="List all incident feeds.",
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset from which to start listing incident feeds.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="How many incident feeds to return.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     *
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
     * @Operation(
     *     tags={""},
     *     summary="Gets a network admin for a given id",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the network is not found"
     *     )
     * )
     *
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
     * @Operation(
     *     tags={""},
     *     summary="Creates a new network from the submitted data.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="formData",
     *         description="",
     *         required=false,
     *         type="object (NetworkType)"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     *
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
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     *
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
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     *
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
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     *
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
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     *
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
