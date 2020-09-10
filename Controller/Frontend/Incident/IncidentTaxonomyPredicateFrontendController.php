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

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyPredicate;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentTaxonomyPredicateFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyPredicate/Frontend:home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_taxonomy_predicate_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_taxonomy_predicate
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_taxonomy_predicate): array
    {
        return $this->homeEntity($request, $elastica_finder_taxonomy_predicate);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyPredicate/Frontend:incidentTaxonomyPredicateDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_taxonomy_predicate_detail")
     * @param TaxonomyPredicate $taxonomyPredicate
     * @return array
     */
    public function detailIncidentTaxonomyPredicateAction(TaxonomyPredicate $taxonomyPredicate): array
    {
        return $this->detailEntity($taxonomyPredicate);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyPredicate/Frontend:frontend.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_taxonomy_predicate_search")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_taxonomy_predicate
     * @return array
     */
    public function searchIncidentTaxonomyPredicateAction(Request $request, PaginatedFinderInterface $elastica_finder_taxonomy_predicate): array
    {
        return $this->searchEntity($request, $elastica_finder_taxonomy_predicate);
    }

}
