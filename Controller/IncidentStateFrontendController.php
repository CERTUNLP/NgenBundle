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
 * Description of IncidentStateFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CertUnlp\NgenBundle\Form\IncidentStateType;
use CertUnlp\NgenBundle\Entity\IncidentState;

class IncidentStateFrontendController extends Controller {

    public function getFrontendController() {
        return $this->get('cert_unlp.ngen.incident.state.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_incident_state_frontend_home")
     */
    public function homeAction(Request $request) {
        return $this->getFrontendController()->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_state_search")
     */
    public function searchIncidentStateAction(Request $request) {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/incidentStateForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_state_new")
     */
    public function newIncidentStateAction(Request $request) {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/incidentStateForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_state_edit")
     */
    public function editIncidentStateAction(IncidentState $incidentState) {
        return $this->getFrontendController()->editEntity($incidentState);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/incidentStateDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_state_detail")
     */
    public function detailIncidentStateAction(IncidentState $incidentState) {
        return $this->getFrontendController()->detailEntity($incidentState);
    }

}
