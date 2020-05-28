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
 * Description of IncidentDecisionFrontendController
 *
 * @author einar
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use CertUnlp\NgenBundle\Form\IncidentDecisionType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentDecisionFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_incident_decision_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_decision
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_decision): array
    {
        return $this->homeEntity($request, $elastica_finder_decision);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_decision_search")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_decision
     * @return array
     */
    public function searchIncidentDecisionAction(Request $request, PaginatedFinderInterface $elastica_finder_decision): array
    {
        return $this->searchEntity($request, $elastica_finder_decision);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/incidentDecisionForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_decision_new")
     * @param Request $request
     * @param IncidentDecisionType $type
     * @return array
     */
    public function newIncidentDecisionAction(Request $request, IncidentDecisionType $type): array
    {
        return $this->newEntity($request, $type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/incidentDecisionForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_incident_decision_edit")
     * @param IncidentDecision $incident_decision
     * @param IncidentDecisionType $type
     * @return array
     */
    public function editIncidentDecisionAction(IncidentDecision $incident_decision, IncidentDecisionType $type): array
    {
        return $this->editEntity($incident_decision, $type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/incidentDecisionDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_incident_decision_detail")
     * @param IncidentDecision $incident_decision
     * @return array
     */
    public function detailIncidentDecisionAction(IncidentDecision $incident_decision): array
    {
        return $this->detailEntity($incident_decision);
    }

}
