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

use CertUnlp\NgenBundle\Entity\Incident\IncidentDecision;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IncidentDecisionFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_incident_decision_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.incident.decision.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_decision_search")
     * @param Request $request
     * @return array
     */
    public function searchIncidentDecisionAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/incidentDecisionForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_decision_new")
     * @param Request $request
     * @return array
     */
    public function newIncidentDecisionAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/incidentDecisionForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_incident_decision_edit")
     * @param IncidentDecision $IncidentDecision
     * @return array
     */
    public function editIncidentDecisionAction(IncidentDecision $IncidentDecision)
    {
        return $this->getFrontendController()->editEntity($IncidentDecision);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/incidentDecisionDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_incident_decision_detail")
     * @param IncidentDecision $IncidentDecision
     * @return array
     */
    public function detailIncidentDecisionAction(IncidentDecision $IncidentDecision)
    {
        return $this->getFrontendController()->detailEntity($IncidentDecision);
    }

}
