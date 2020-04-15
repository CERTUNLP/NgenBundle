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

use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentTaxonomyValueController extends FOSRestController
{

    /**
     * List all incident states.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @FOS\Get("/taxonomies/values")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident states.")
     * @FOS\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many incident states to return.")
     *
     * @FOS\View(
     *  templateVar="incident_states"
     * )
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getTaxonomyValuesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.incident.taxonomy.value.api.controller');
    }

    /**
     * Gets a Network for a given id.
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
     * @param TaxonomyValue $taxonomyValue
     * @return TaxonomyValue
     * @FOS\Get("/taxonomies/values/{slug}")
     */
    public function getTaxonomyValueAction(TaxonomyValue $taxonomyValue)
    {
        return $taxonomyValue;
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
     * @FOS\Post("/taxonomies/values")
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postTaxonomyValueAction(Request $request)
    {
        return $this->getApiController()->post($request);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\TaxonomyValueType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @FOS\Patch("/taxonomies/values/{slug}")
     * @param Request $request the request object
     * @param TaxonomyValue $taxonomyValue
     * @return FormTypeInterface|View
     *
     */
    public function patchTaxonomyValueAction(Request $request, TaxonomyValue $taxonomyValue)
    {
        return $this->getApiController()->patch($request, $taxonomyValue, true);
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
     * @FOS\Patch("/taxonomies/values/{slug}")
     * @param Request $request the request object
     * @param TaxonomyValue $taxonomyValue
     * @return FormTypeInterface|View
     *
     */
    public function patchTaxonomyValueBySlugAction(Request $request, TaxonomyValue $taxonomyValue)
    {
        return $this->getApiController()->patch($request, $taxonomyValue);
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
     * @param TaxonomyValue $taxonomyValue
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/taxonomies/values/{slug}/activate")
     */
    public function patchTaxonomyValueActivateAction(Request $request, TaxonomyValue $taxonomyValue)
    {

        return $this->getApiController()->activate($request, $taxonomyValue);
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
     * @param TaxonomyValue $taxonomyValue
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/taxonomies/values/{slug}/desactivate")
     */
    public function patchTaxonomyValueDesactivateAction(Request $request, TaxonomyValue $taxonomyValue)
    {

        return $this->getApiController()->desactivate($request, $taxonomyValue);
    }

}
