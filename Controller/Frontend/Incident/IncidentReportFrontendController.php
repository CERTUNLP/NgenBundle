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
use CertUnlp\NgenBundle\Form\IncidentReportType;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentReportFrontendController extends FrontendController
{
    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/list/incidentReportList.html.twig")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_report
     * @param string $term
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_report, string $term = ''): array
    {
        return $this->homeEntity($request, $elastica_finder_report, 'slug:' . $term . '-*');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportForm.html.twig")
     * @Route("reports/new", name="cert_unlp_ngen_incident_type_report_new")
     * @param Request $request
     * @param IncidentReportType $entity_type
     * @return array
     */
    public function newIncidentReportAction(Request $request, IncidentReportType $entity_type): array
    {
        return $this->newEntity($request, $entity_type);
    }

    /**
     * {@inheritDoc}
     */
    public function newEntity(Request $request, AbstractType $form, string $default_type = ''): array
    {
        $response = parent::newEntity($request, $form);
        $response['default_type'] = $default_type;
        return $response;
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportForm.html.twig")
     * @Route("{slug}/reports/{lang}/edit", name="cert_unlp_ngen_incident_type_report_edit")
     * @ParamConverter("lang", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @param IncidentReportType $entity_type
     * @return array
     */
    public function editIncidentReportAction(IncidentType $slug, IncidentReport $lang, IncidentReportType $entity_type): array
    {
        return $this->editEntity($lang, $entity_type, $slug);
    }


    /**
     * {@inheritDoc}
     */
    public function editEntity(EntityApiInterface $object, AbstractType $form, string $default_type = ''): array
    {
        $response = parent::editEntity($object, $form);
        $response['default_type'] = $default_type;
        return $response;
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentReport:Frontend/incidentReportDetail.html.twig")
     * @Route("{slug}/reports/{lang}/detail", name="cert_unlp_ngen_incident_type_report_detail")
     * @ParamConverter("lang", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @param IncidentReportFrontendController $controller_service
     * @return array
     */
    public function detailIncidentReportAction(IncidentType $slug, IncidentReport $lang, IncidentReportFrontendController $controller_service): array
    {
        return $this->detailEntity($lang);
    }
}
