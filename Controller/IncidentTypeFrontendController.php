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
 * Description of IncidentTypeFrontendController
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
use CertUnlp\NgenBundle\Form\IncidentTypeType;
use CertUnlp\NgenBundle\Entity\IncidentType;

class IncidentTypeFrontendController extends Controller {

    public function getFrontendController() {
        return $this->get('cert_unlp.ngen.incident.type.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_incident_type_frontend_home")
     */
    public function homeAction(Request $request) {
        return $this->getFrontendController()->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_type_search")
     */
    public function searchIncidentTypeAction(Request $request) {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_type_new")
     */
    public function newIncidentTypeAction(Request $request) {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_type_edit")
     */
    public function editIncidentTypeAction(IncidentType $incidentType) {
//        $incidentType->setReportEdit($this->readReportFile($incidentType));

        return $this->getFrontendController()->editEntity($incidentType);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_type_detail")
     */
    public function detailIncidentTypeAction(IncidentType $incidentType) {
        return $this->getFrontendController()->detailEntity($incidentType);
    }

    private function getReportName(IncidentType $incidentType) {
        return $this->getParameter('cert_unlp.ngen.incident.internal.report.markdown.path') . "/" . $incidentType->getReportName();
    }

    private function readReportFile(IncidentType $incidentType) {
        return $this->container->get('markdown.parser')->transformMarkdown(file_get_contents($this->getReportName($incidentType)));
    }

}
