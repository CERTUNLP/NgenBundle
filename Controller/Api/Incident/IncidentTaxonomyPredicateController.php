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
use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyPredicate;
use CertUnlp\NgenBundle\Form\IncidentTaxonomyPredicateType;
use CertUnlp\NgenBundle\Service\Api\Handler\TaxonomyPredicateHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;

class IncidentTaxonomyPredicateController extends ApiController
{
    /**
     * IncidentTaxonomyPredicateController constructor.
     * @param TaxonomyPredicateHandler $handler
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(TaxonomyPredicateHandler $handler, ViewHandlerInterface $viewHandler)
    {
        parent::__construct($handler, $viewHandler);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy predicates"},
     *     summary="List all incident states.",
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset from which to start listing incident states.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="How many incident states to return.",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyPredicate::class, groups={"api"}))
     *          )
     *     ),
     * )
     * @FOS\Get("/taxonomies/predicates")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident states.")
     * @FOS\QueryParam(name="limit", requirements="\d+", strict=true, default="100", description="How many incident states to return.")
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return View
     */
    public function getTaxonomyPredicatesAction(ParamFetcherInterface $paramFetcher): View
    {
        return $this->getAll($paramFetcher);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy predicates"},
     *     summary="Gets a network admin for a given id",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyPredicate::class, groups={"api"}))
     *          )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the network is not found"
     *     )
     * )
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return View
     * @FOS\Get("/taxonomies/predicates/{slug}")
     */
    public function getTaxonomyPredicateAction(TaxonomyPredicate $taxonomyPredicate): View
    {
        return $this->response([$taxonomyPredicate], Response::HTTP_OK);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy predicates"},
     *     summary="Creates a new network from the submitted data.",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentTaxonomyPredicateType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyPredicate::class, groups={"api"}))
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
     * @FOS\Post("/taxonomies/predicates")
     * @param Request $request the request object
     * @return View
     */
    public function postTaxonomyPredicateAction(Request $request): View
    {
        return $this->post($request);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy predicates"},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyPredicate::class, groups={"api"}))
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
     * @FOS\Patch("/taxonomies/predicates/{slug}")
     * @param Request $request the request object
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return View
     */
    public function patchTaxonomyPredicateAction(Request $request, TaxonomyPredicate $taxonomyPredicate): View
    {
        return $this->patch($request, $taxonomyPredicate, true);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy predicates"},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentTaxonomyType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyPredicate::class, groups={"api"}))
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
     * @param Request $request the request object
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return View
     * @FOS\Patch("/taxonomies/predicates/{slug}/activate")
     */
    public function patchTaxonomyPredicateActivateAction(Request $request, TaxonomyPredicate $taxonomyPredicate): View
    {
        return $this->activate($request, $taxonomyPredicate);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy predicates"},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentTaxonomyType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyPredicate::class, groups={"api"}))
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
     * @param Request $request the request object
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return View
     * @FOS\Patch("/taxonomies/predicates/{slug}/desactivate")
     */
    public function patchTaxonomyPredicateDesactivateAction(Request $request, TaxonomyPredicate $taxonomyPredicate): View
    {
        return $this->desactivate($request, $taxonomyPredicate);
    }

}
