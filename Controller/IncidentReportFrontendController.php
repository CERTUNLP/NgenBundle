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
 * Description of IncidentReportFrontendController
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
use CertUnlp\NgenBundle\Form\IncidentReportType;
use CertUnlp\NgenBundle\Entity\IncidentReport;
use CertUnlp\NgenBundle\Entity\IncidentType;

class IncidentReportFrontendController extends Controller {

    public function getFrontendController() {
        return $this->get('cert_unlp.ngen.incident.report.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/list/incidentReportList.html.twig")
     */
    public function homeAction(Request $request, $term = null) {
//        var_dump($request,$term);die;
        return $this->getFrontendController()->homeEntity($request, $term);
    }

//
//    /**
//     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/home.html.twig")
//     * @Route("search", name="cert_unlp_ngen_incident_type_report_search")
//     */
//    public function searchIncidentReportAction(Request $request) {
//        return $this->getFrontendController()->searchEntity($request);
//    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportForm.html.twig")
     * @Route("reports/new", name="cert_unlp_ngen_incident_type_report_new")
     */
    public function newIncidentReportAction(Request $request) {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportForm.html.twig")
     * @Route("{slug}/reports/{lang}/edit", name="cert_unlp_ngen_incident_type_report_edit")
     * @ParamConverter("lang", class="CertUnlpNgenBundle:IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function editIncidentReportAction(IncidentType $slug, IncidentReport $lang) {
//        $incidentReport->setReportEdit($this->readReportFile($incidentReport));

        return $this->getFrontendController()->editEntity($lang);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportDetail.html.twig")
     * @Route("{slug}/reports/{lang}/detail", name="cert_unlp_ngen_incident_type_report_detail")
     * @ParamConverter("lang", class="CertUnlpNgenBundle:IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function detailIncidentReportAction(IncidentType $slug, IncidentReport $lang) {
        return $this->getFrontendController()->detailEntity($lang);
    }

}
