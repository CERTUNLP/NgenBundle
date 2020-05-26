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

use CertUnlp\NgenBundle\Entity\Incident\Taxonomy\TaxonomyValue;
use CertUnlp\NgenBundle\Service\Frontend\Controller\FrontendControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentTaxonomyValueFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyValue/Frontend:home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_taxonomy_value_frontend_home")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyValue/Frontend:incidentTaxonomyValueDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_taxonomy_value_detail")
     * @param TaxonomyValue $taxonomyValue
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function detailIncidentTaxonomyValueAction(TaxonomyValue $taxonomyValue, FrontendControllerService $controller_service): array
    {
        return $controller_service->detailEntity($taxonomyValue);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyValue/Frontend:frontend.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_taxonomy_value_search")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function searchIncidentTaxonomyValueAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->searchEntity($request);
    }
}
