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

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Incident\IncidentReport;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Form\Incident\IncidentReportType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentReportFrontendController extends FrontendController
{
    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/list/incidentReportList.html.twig")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_report
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_report): array
    {
        return $this->homeEntity($request, $elastica_finder_report);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportForm.html.twig")
     * @Route("{type}/reports/new", name="cert_unlp_ngen_incident_type_report_new")
     * @ParamConverter("type", class="CertUnlp\NgenBundle\Entity\Incident\IncidentType", options={"mapping": {"type": "slug"}})
     * @param IncidentReportType $entity_type
     * @param IncidentType $type
     * @return array
     */
    public function newIncidentReportAction(IncidentReportType $entity_type, IncidentType $type): array
    {
        $report = new IncidentReport();
        $report->setType($type);
        return array('form' => $this->getFormFactory()->create(get_class($entity_type), $report, ['frontend' => true, 'method' => Request::METHOD_POST])->createView());
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportForm.html.twig")
     * @Route("{type}/reports/{lang}/edit", name="cert_unlp_ngen_incident_type_report_edit")
     * @param IncidentReport $incident_report
     * @param IncidentReportType $entity_type
     * @return array
     */
    public function editIncidentReportAction(IncidentReport $incident_report, IncidentReportType $entity_type): array
    {
        return $this->editEntity($incident_report, $entity_type);
    }


    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportDetail.html.twig")
     * @Route("{type}/reports/{lang}/detail", name="cert_unlp_ngen_incident_type_report_detail")
     * @param IncidentReport $incident_report
     * @return array
     */
    public function detailIncidentReportAction(IncidentReport $incident_report): array
    {
        return $this->detailEntity($incident_report);
    }
}
