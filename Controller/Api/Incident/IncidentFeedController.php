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

use CertUnlp\NgenBundle\Controller\Api\ApiController;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use CertUnlp\NgenBundle\Form\IncidentFeedType;
use CertUnlp\NgenBundle\Service\Api\Handler\IncidentFeedHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IncidentFeedController extends ApiController
{
    /**
     * IncidentFeedController constructor.
     * @param IncidentFeedHandler $handler
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(IncidentFeedHandler $handler, ViewHandlerInterface $viewHandler)
    {
        parent::__construct($handler, $viewHandler);
    }

    /**
     * @Operation(
     *     tags={"Incident feeds"},
     *     summary="List all incident feeds.",
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset from which to start listing",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="How many entities to return",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentFeed::class, groups={"api"}))
     *          )
     *     )
     * )
     * @FOS\Get("/feeds")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident feeds.")
     * @FOS\QueryParam(name="limit", requirements="\d+", strict=true, default="100", description="How many incident feeds to return.")
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return View
     */
    public function getIncidentFeedsAction(ParamFetcherInterface $paramFetcher): View
    {
        return $this->getAll($paramFetcher);
    }

    /**
     * @Operation(
     *     tags={"Incident feeds"},
     *     summary="Gets a feed for a given id",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentFeed::class, groups={"api"}))
     *          )
     *     ),
     *      @SWG\Response(
     *         response="404",
     *         description="Returned when the incident is not found",
     *          @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *     )
     * )
     * @FOS\Get("/feeds/{slug}")
     * @param IncidentFeed $incident_feed
     * @return View
     */
    public function getIncidentFeedAction(IncidentFeed $incident_feed): View
    {
        try {
            return $this->response([$incident_feed], Response::HTTP_OK);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @Operation(
     *     tags={"Incident feeds"},
     *     summary="Removes a feed",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentFeed::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Delete("/feeds/{slug}"))
     * @param IncidentFeed $incident_feed
     * @return View
     */
    public function deleteIncidentFeedAction(IncidentFeed $incident_feed): View
    {
        return $this->delete($incident_feed);
    }

    /**
     * Create a Network from the submitted data.
     *
     * @Operation(
     *     tags={"Incident feeds"},
     *     summary="Creates a new feed from the submitted data.",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentFeedType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentFeed::class, groups={"api"}))
     *          )
     *      ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Post("/feeds")
     * @param Request $request the request object
     * @return View
     */
    public function postIncidentFeedAction(Request $request): View
    {
        return $this->post($request);
    }

    /**
     * @Operation(
     *     tags={"Incident feeds"},
     *     summary="Update existing feed from the submitted data",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentFeedType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentFeed::class, groups={"api"}))
     *          )
     *      ),
     *      @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Patch("/feeds/{slug}")
     * @param Request $request the request object
     * @param IncidentFeed $incident_feed
     * @return View
     */
    public function patchIncidentFeedAction(Request $request, IncidentFeed $incident_feed): View
    {
        return $this->patch($request, $incident_feed, true);
    }

    /**
     * @Operation(
     *     tags={"Incident feeds"},
     *     summary="Activates an existing feed",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentFeed::class, groups={"api"}))
     *          )
     *      ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Patch("/feeds/{slug}/activate")
     * @param IncidentFeed $incident_feed
     * @return View
     */
    public function patchIncidentFeedActivateAction(IncidentFeed $incident_feed): View
    {
        return $this->activate($incident_feed);
    }

    /**
     * @Operation(
     *     tags={"Incident feeds"},
     *     summary="Desactivates an existing feed",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentFeed::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Patch("/feeds/{slug}/desactivate")
     * @param IncidentFeed $incident_feed
     * @return View
     */
    public function patchIncidentFeedDesactivateAction(IncidentFeed $incident_feed): View
    {
        return $this->desactivate($incident_feed);
    }

}
