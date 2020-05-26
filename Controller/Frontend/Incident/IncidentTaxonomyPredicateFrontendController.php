<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Description of IncidentPredicateFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyPredicate;
use CertUnlp\NgenBundle\Service\Frontend\Controller\FrontendControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentTaxonomyPredicateFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyPredicate/Frontend:home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_taxonomy_predicate_frontend_home")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyPredicate/Frontend:incidentTaxonomyPredicateDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_taxonomy_predicate_detail")
     * @param TaxonomyPredicate $taxonomyPredicate
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function detailIncidentTaxonomyPredicateAction(TaxonomyPredicate $taxonomyPredicate, FrontendControllerService $controller_service): array
    {
        return $controller_service->detailEntity($taxonomyPredicate);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyPredicate/Frontend:frontend.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_taxonomy_predicate_search")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function searchIncidentTaxonomyPredicateAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->searchEntity($request);
    }

}
