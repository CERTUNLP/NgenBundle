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
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller;

use CertUnlp\NgenBundle\Entity\IncidentDecision;
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
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/IncidentDecisionForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_decision_new")
     * @param Request $request
     * @return array
     */
    public function newIncidentDecisionAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/IncidentDecisionForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_decision_edit")
     * @param IncidentDecision $IncidentDecision
     * @return array
     */
    public function editIncidentDecisionAction(IncidentDecision $IncidentDecision)
    {
        return $this->getFrontendController()->editEntity($IncidentDecision);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentDecision:Frontend/IncidentDecisionDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_decision_detail")
     * @param IncidentDecision $IncidentDecision
     * @return array
     */
    public function detailIncidentDecisionAction(IncidentDecision $IncidentDecision)
    {
        return $this->getFrontendController()->detailEntity($IncidentDecision);
    }

}
