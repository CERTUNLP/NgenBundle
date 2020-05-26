<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Service\Frontend\Controller\IncidentFrontendControllerService;
use fados\ChartjsBundle\Model\ChartBuiderData;
use fados\ChartjsBundle\Utils\TypeCharjs;
use fados\ChartjsBundle\Utils\TypeColors;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IncidentFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_internal_incident_frontend_home")
     * @param Request $request
     * @param IncidentFrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, IncidentFrontendControllerService $controller_service): array
    {
        return $controller_service->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_internal_incident_frontend_new_incident")
     * @param Request $request
     * @param IncidentFrontendControllerService $controller_service
     * @return array
     */
    public function newIncidentAction(Request $request, IncidentFrontendControllerService $controller_service): array
    {
        return $controller_service->newEntity($request);
    }


    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_internal_incident_frontend_edit_incident_id",requirements={"id"="\d+"})
     * @Route("{slug}/edit", name="cert_unlp_ngen_internal_incident_frontend_edit_incident")
     * @param Incident $incident
     * @param IncidentFrontendControllerService $controller_service
     * @return array
     */
    public function editIncidentAction(Incident $incident, IncidentFrontendControllerService $controller_service): array
    {
        return $controller_service->editEntity($incident);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_internal_incident_frontend_detail_incident_id",requirements={"id"="\d+"})
     * @Route("{slug}/detail", name="cert_unlp_ngen_internal_incident_frontend_detail_incident")
     * @param Incident $incident
     * @param IncidentFrontendControllerService $controller_service
     * @return array
     */
    public function detailIncidentAction(Incident $incident, IncidentFrontendControllerService $controller_service): array
    {
        $response['object'] = $incident;
        $response['timeline'] = null;
//        $response['piechart_state'] = $this->makePieChart($incident->getStateRatio());
        $response['piechart_feed'] = $controller_service->makePieChart($incident->getFeedRatio());
        $response['piechart_priority'] = $controller_service->makePieChart($incident->getPriorityRatio());
        $response['piechart_tlp'] = $controller_service->makePieChart($incident->getTlpRatio());
        if ($incident->getStatechanges()->count() > 1) {
            $response['timeline'] = $controller_service->makeTimeline($incident->getStateTimelineRatio());
        }
        $response['column_chart'] = $controller_service->makeColumnChart($incident->getDateRatio());
        return $response;
    }


    /**
     * @Route("{id}/evidence", name="cert_unlp_ngen_internal_incident_frontend_evidence_incident_id", requirements={"id"="\d+"})
     * @Route("{slug}/evidence", name="cert_unlp_ngen_internal_incident_frontend_evidence_incident")
     * @param Incident $incident
     * @param IncidentFrontendControllerService $controller_service
     * @return Response
     */
    public function evidenceIncidentAction(Incident $incident, IncidentFrontendControllerService $controller_service): Response
    {

        return $controller_service->evidenceIncidentAction($incident);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_internal_incident_search_incident")
     * @param Request $request
     * @param IncidentFrontendControllerService $controller_service
     * @return array
     */
    public function searchIncidentAction(Request $request, IncidentFrontendControllerService $controller_service): array

    {
        return $controller_service->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentComments.html.twig")
     * @param Incident $incident
     * @param Request $request
     * @param IncidentFrontendControllerService $controller_service
     * @return array
     */
    public function incidentCommentsAction(Incident $incident, Request $request, IncidentFrontendControllerService $controller_service): array
    {
        return $controller_service->commentsEntity($incident, $request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/list/incidentListRow.html.twig")
     * @Route("{id}/getListRow", name="cert_unlp_ngen_incident_frontend_get_list_row_incident_id", requirements={"id"="\d+"})
     * @param Incident $incident
     * @return array
     */
    public function getListRow(Incident $incident): array
    {
        return array('incident' => $incident);
    }

    /**
     * @Route("getFilterList", name="cert_unlp_ngen_incident_ajax_search_incident")
     * @param Request $request
     * @param IncidentFrontendControllerService $controller_service
     * @return JsonResponse
     */
    public function getFilterIncidentListAction(Request $request, IncidentFrontendControllerService $controller_service): JsonResponse
    {
        $datos = $controller_service->homeEntity($request);
        $tabla = $this->renderView("CertUnlpNgenBundle:Incident:Frontend/list/filterList.html.twig", $datos);
        $paginador = $this->renderView("CertUnlpNgenBundle:Incident:Frontend/list/filterListPaginator.html.twig", $datos);
        $filters = $this->renderView("CertUnlpNgenBundle:Incident:Frontend/list/filterHeadersPaginator.html.twig", $datos);
        $indice = $datos['objects']->getPaginationData();
        return new JsonResponse(array('tabla' => $tabla, 'indice' => $indice, 'paginador' => $paginador, 'filters' => $filters));

    }
}
