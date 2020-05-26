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

use CertUnlp\NgenBundle\Entity\Incident\IncidentReport;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Service\Frontend\Controller\IncidentReportFrontendControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentReportFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/list/incidentReportList.html.twig")
     * @param Request $request
     * @param string $term
     * @param IncidentReportFrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, IncidentReportFrontendControllerService $controller_service, string $term = ''): array
    {
        return $controller_service->homeEntity($request, 'slug:' . $term . '-*');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportForm.html.twig")
     * @Route("reports/new", name="cert_unlp_ngen_incident_type_report_new")
     * @param Request $request
     * @param IncidentReportFrontendControllerService $controller_service
     * @return array
     */
    public function newIncidentReportAction(Request $request, IncidentReportFrontendControllerService $controller_service): array
    {
        return $controller_service->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportForm.html.twig")
     * @Route("{slug}/reports/{lang}/edit", name="cert_unlp_ngen_incident_type_report_edit")
     * @ParamConverter("lang", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @param IncidentReportFrontendControllerService $controller_service
     * @return array
     */
    public function editIncidentReportAction(IncidentType $slug, IncidentReport $lang, IncidentReportFrontendControllerService $controller_service): array
    {
        return $controller_service->editEntity($lang, $slug);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportDetail.html.twig")
     * @Route("{slug}/reports/{lang}/detail", name="cert_unlp_ngen_incident_type_report_detail")
     * @ParamConverter("lang", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @param IncidentReportFrontendControllerService $controller_service
     * @return array
     */
    public function detailIncidentReportAction(IncidentType $slug, IncidentReport $lang, IncidentReportFrontendControllerService $controller_service): array
    {
        return $controller_service->detailEntity($lang);
    }

}
