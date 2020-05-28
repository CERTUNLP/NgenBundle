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
 * Description of IncidentValueFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentTaxonomyValueFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyValue/Frontend:home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_taxonomy_value_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_taxonomy_value
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_taxonomy_value): array
    {
        return $this->homeEntity($request, $elastica_finder_taxonomy_value);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyValue/Frontend:incidentTaxonomyValueDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_taxonomy_value_detail")
     * @param TaxonomyValue $taxonomyValue
     * @return array
     */
    public function detailIncidentTaxonomyValueAction(TaxonomyValue $taxonomyValue): array
    {
        return $this->detailEntity($taxonomyValue);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyValue/Frontend:frontend.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_taxonomy_value_search")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_taxonomy_value
     * @return array
     */
    public function searchIncidentTaxonomyValueAction(Request $request, PaginatedFinderInterface $elastica_finder_taxonomy_value): array
    {
        return $this->searchEntity($request, $elastica_finder_taxonomy_value);
    }
}
