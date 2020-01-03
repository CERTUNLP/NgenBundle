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

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentTlp;
use CertUnlp\NgenBundle\Entity\Incident\Report\IncidentReport;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Services\IncidentFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IncidentReportFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/list/incidentReportList.html.twig")
     * @param Request $request
     * @param null $term
     * @return array
     */
    public function homeAction(Request $request, $term = null)
    {
        return $this->getFrontendController()->homeEntity($request, 'slug:' . $term . '-*');
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.incident.report.frontend.controller');
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
     * @param Request $request
     * @return array
     */
    public function newIncidentReportAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportForm.html.twig")
     * @Route("{slug}/reports/{lang}/edit", name="cert_unlp_ngen_incident_type_report_edit")
     * @ParamConverter("lang", class="CertUnlp\NgenBundle\Entity\Incident\Report\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @return array
     */
    public function editIncidentReportAction(IncidentType $slug, IncidentReport $lang)
    {
//        $incidentReport->setReportEdit($this->readReportFile($incidentReport));
        return $this->getFrontendController()->editEntity($lang);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportDetail.html.twig")
     * @Route("{slug}/reports/{lang}/detail", name="cert_unlp_ngen_incident_type_report_detail")
     * @ParamConverter("lang", class="CertUnlp\NgenBundle\Entity\Incident\Report\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @return array
     */
    public function detailIncidentReportAction(IncidentType $slug, IncidentReport $lang)
    {
        $incidentFactory = $this->get('cert_unlp.ngen.incident.factory');
        $incident = $incidentFactory->getIncident($slug);
        $team=$incidentFactory->getTeam();
        return array('team'=> $team,'object' => $lang,'incident'=> $incident );
    }

}
