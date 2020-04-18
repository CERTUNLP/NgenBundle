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

use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyPredicate;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentTaxonomyPredicateController extends AbstractFOSRestController
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
     * @FOS\Get("/taxonomies/predicates")
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
    public function getTaxonomyPredicatesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.incident.taxonomy.predicate.api.controller');
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
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return TaxonomyPredicate
     * @FOS\Get("/taxonomies/predicates/{slug}")
     */
    public function getTaxonomyPredicateAction(TaxonomyPredicate $taxonomyPredicate)
    {
        return $taxonomyPredicate;
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
     * @FOS\Post("/taxonomies/predicates")
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postTaxonomyPredicateAction(Request $request)
    {
        return $this->getApiController()->post($request);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\TaxonomyPredicateType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @FOS\Patch("/taxonomies/predicates/{slug}")
     * @param Request $request the request object
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return FormTypeInterface|View
     *
     */
    public function patchTaxonomyPredicateAction(Request $request, TaxonomyPredicate $taxonomyPredicate)
    {
        return $this->getApiController()->patch($request, $taxonomyPredicate, true);
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
     * @FOS\Patch("/taxonomies/predicates/{slug}")
     * @param Request $request the request object
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return FormTypeInterface|View
     *
     */
    public function patchTaxonomyPredicateBySlugAction(Request $request, TaxonomyPredicate $taxonomyPredicate)
    {
        return $this->getApiController()->patch($request, $taxonomyPredicate);
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
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/taxonomies/predicates/{slug}/activate")
     */
    public function patchTaxonomyPredicateActivateAction(Request $request, TaxonomyPredicate $taxonomyPredicate)
    {

        return $this->getApiController()->activate($request, $taxonomyPredicate);
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
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/taxonomies/predicates/{slug}/desactivate")
     */
    public function patchTaxonomyPredicateDesactivateAction(Request $request, TaxonomyPredicate $taxonomyPredicate)
    {

        return $this->getApiController()->desactivate($request, $taxonomyPredicate);
    }

}
