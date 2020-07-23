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
use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue;
use CertUnlp\NgenBundle\Form\Incident\Taxonomy\TaxonomyValueType;
use CertUnlp\NgenBundle\Service\Api\Handler\Incident\Taxonomy\TaxonomyValueHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaxonomyValueController extends ApiController
{
    /**
     * IncidentTaxonomyValueController constructor.
     * @param TaxonomyValueHandler $handler
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(TaxonomyValueHandler $handler, ViewHandlerInterface $viewHandler)
    {
        parent::__construct($handler, $viewHandler);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy values"},
     *     summary="List all taxonomy values.",
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
     *              @SWG\Items(ref=@Model(type=TaxonomyValue::class, groups={"api"}))
     *          )
     *     ),
     * )
     * @FOS\Get("/taxonomies/values")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident states.")
     * @FOS\QueryParam(name="limit", requirements="\d+", strict=true, default="100", description="How many incident states to return.")
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return View
     */
    public function getTaxonomyValuesAction(ParamFetcherInterface $paramFetcher): View
    {
        return $this->getAll($paramFetcher);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy values"},
     *     summary="Removes a taxonomy value",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyValue::class, groups={"api"}))
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
     * @FOS\Delete("/taxonomies/values/{slug}"))
     * @param TaxonomyValue $taxonomy_value
     * @return View
     */
    public function deleteIncidentStateAction(TaxonomyValue $taxonomy_value): View
    {
        return $this->delete($taxonomy_value);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy values"},
     *     summary="Gets a value for a given id",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyValue::class, groups={"api"}))
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
     * @param TaxonomyValue $taxonomyValue
     * @return View
     * @FOS\Get("/taxonomies/values/{slug}")
     */
    public function getTaxonomyValueAction(TaxonomyValue $taxonomyValue): View
    {
        return $this->response([$taxonomyValue], Response::HTTP_OK);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy values"},
     *     summary="Creates a new value from the submitted data.",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=TaxonomyValueType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyValue::class, groups={"api"}))
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
     * @FOS\Post("/taxonomies/values")
     * @param Request $request the request object
     * @return View
     */
    public function postTaxonomyValueAction(Request $request): View
    {
        return $this->post($request);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy values"},
     *     summary="Update existing value from the submitted data",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyValue::class, groups={"api"}))
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
     * @FOS\Patch("/taxonomies/values/{slug}")
     * @param Request $request the request object
     * @param TaxonomyValue $taxonomyValue
     * @return View
     */
    public function patchTaxonomyValueAction(Request $request, TaxonomyValue $taxonomyValue): View
    {
        return $this->patch($request, $taxonomyValue);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy values"},
     *     summary="Activates an existing value",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyValue::class, groups={"api"}))
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
     * @param TaxonomyValue $taxonomyValue
     * @return View
     * @FOS\Patch("/taxonomies/values/{slug}/activate")
     */
    public function patchTaxonomyValueActivateAction(TaxonomyValue $taxonomyValue): View
    {
        return $this->activate($taxonomyValue);
    }

    /**
     * @Operation(
     *     tags={"Incident taxonomy values"},
     *     summary="Desactivates an existing value",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=TaxonomyValue::class, groups={"api"}))
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
     * @param TaxonomyValue $taxonomyValue
     * @return View
     * @FOS\Patch("/taxonomies/values/{slug}/desactivate")
     */
    public function patchTaxonomyValueDesactivateAction(TaxonomyValue $taxonomyValue): View
    {
        return $this->desactivate($taxonomyValue);
    }

}
