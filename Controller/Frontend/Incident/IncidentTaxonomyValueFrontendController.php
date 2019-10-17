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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IncidentTaxonomyValueFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyValues/Frontend:home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_taxonomy_value_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.incident.taxonomy.value.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyValues/Frontend:home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_taxonomy_value_search")
     * @param Request $request
     * @return array
     */
    public function searchIncidentTaxonomyValueAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentTaxonomyValues/Frontend:incidentTaxonomyValueDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_taxonomy_value_detail")
     * @param TaxonomyValue $taxonomyValue
     * @return array
     */
    public function detailIncidentTypeAction(TaxonomyValue $taxonomyValue)
    {
        return $this->getFrontendController()->detailEntity($taxonomyValue);
    }

    private function readReportFile( TaxonomyValue $incidentType)
    {
        return $this->container->get('markdown.parser')->transformMarkdown(file_get_contents($this->getReportName($incidentType)));
    }

    private function getReportName($incidentType)
    {
        return $this->getParameter('cert_unlp.ngen.incident.internal.report.markdown.path') . "/" . $incidentType->getReportName();
    }

}
