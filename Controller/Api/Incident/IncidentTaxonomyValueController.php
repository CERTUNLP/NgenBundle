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
use CertUnlp\NgenBundle\Service\Api\Handler\TaxonomyValueHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentTaxonomyValueController extends ApiController
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
     * @FOS\Get("/taxonomies/values")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident states.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many incident states to return.")
     * @FOS\View(
     *  templateVar="incident_states"
     * )
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return View
     */
    public function getTaxonomyValuesAction(ParamFetcherInterface $paramFetcher): View
    {
        return $this->getAll($paramFetcher);
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
     * @param TaxonomyValue $taxonomyValue
     * @return View
     * @FOS\Get("/taxonomies/values/{slug}")
     */
    public function getTaxonomyValueAction(TaxonomyValue $taxonomyValue): View
    {
        return $this->response([$taxonomyValue]);
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
     * @FOS\Patch("/taxonomies/values/{slug}")
     * @param Request $request the request object
     * @param TaxonomyValue $taxonomyValue
     * @return View
     *
     */
    public function patchTaxonomyValueAction(Request $request, TaxonomyValue $taxonomyValue): View
    {
        return $this->patch($request, $taxonomyValue, true);
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
     * @FOS\Patch("/taxonomies/values/{slug}")
     * @param Request $request the request object
     * @param TaxonomyValue $taxonomyValue
     * @return View
     *
     */
    public function patchTaxonomyValueBySlugAction(Request $request, TaxonomyValue $taxonomyValue): View
    {
        return $this->patch($request, $taxonomyValue);
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
     * @param TaxonomyValue $taxonomyValue
     * @return View
     *
     * @FOS\Patch("/taxonomies/values/{slug}/activate")
     */
    public function patchTaxonomyValueActivateAction(Request $request, TaxonomyValue $taxonomyValue): View
    {
        return $this->activate($request, $taxonomyValue);
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
     * @param TaxonomyValue $taxonomyValue
     * @return View
     * @FOS\Patch("/taxonomies/values/{slug}/desactivate")
     */
    public function patchTaxonomyValueDesactivateAction(Request $request, TaxonomyValue $taxonomyValue): View
    {
        return $this->desactivate($request, $taxonomyValue);
    }

}
