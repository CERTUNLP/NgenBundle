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
use CertUnlp\NgenBundle\Service\Api\Handler\TaxonomyPredicateHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentTaxonomyPredicateController extends ApiController
{
    /**
     * IncidentTaxonomyPredicateController constructor.
     * @param TaxonomyPredicateHandler $handler
     * @param ViewHandlerInterface $viewHandler
     * @param View $view
     */
    public function __construct(TaxonomyPredicateHandler $handler, ViewHandlerInterface $viewHandler, View $view)
    {
        parent::__construct($handler, $viewHandler, $view);
    }

    /**
     * @Operation(
     *     tags={""},
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
     *         description="Returned when successful"
     *     )
     * )
     * @FOS\Get("/taxonomies/predicates")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident states.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many incident states to return.")
     * @FOS\View(
     *  templateVar="incident_states"
     * )
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getTaxonomyPredicatesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getAll($request, $paramFetcher);
    }

    /**
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
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return TaxonomyPredicate
     * @FOS\Get("/taxonomies/predicates/{slug}")
     */
    public function getTaxonomyPredicateAction(TaxonomyPredicate $taxonomyPredicate)
    {
        return $taxonomyPredicate;
    }

    /**
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
     * @FOS\Post("/taxonomies/predicates")
     * @param Request $request the request object
     * @return FormTypeInterface|View
     */
    public function postTaxonomyPredicateAction(Request $request)
    {
        return $this->post($request);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @FOS\Patch("/taxonomies/predicates/{slug}")
     * @param Request $request the request object
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return FormTypeInterface|View
     */
    public function patchTaxonomyPredicateAction(Request $request, TaxonomyPredicate $taxonomyPredicate)
    {
        return $this->patch($request, $taxonomyPredicate, true);
    }

    /**
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
     * @FOS\Patch("/taxonomies/predicates/{slug}")
     * @param Request $request the request object
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return FormTypeInterface|View
     *
     */
    public function patchTaxonomyPredicateBySlugAction(Request $request, TaxonomyPredicate $taxonomyPredicate)
    {
        return $this->patch($request, $taxonomyPredicate);
    }

    /**
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
     * @param Request $request the request object
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return FormTypeInterface|View
     * @FOS\Patch("/taxonomies/predicates/{slug}/activate")
     */
    public function patchTaxonomyPredicateActivateAction(Request $request, TaxonomyPredicate $taxonomyPredicate)
    {
        return $this->activate($request, $taxonomyPredicate);
    }

    /**
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
     * @param Request $request the request object
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return FormTypeInterface|View
     * @FOS\Patch("/taxonomies/predicates/{slug}/desactivate")
     */
    public function patchTaxonomyPredicateDesactivateAction(Request $request, TaxonomyPredicate $taxonomyPredicate)
    {
        return $this->desactivate($request, $taxonomyPredicate);
    }

}
