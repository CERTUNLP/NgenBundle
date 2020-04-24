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
use CertUnlp\NgenBundle\Services\Frontend\Controller\IncidentFrontendControllerService as FrontendControllerService;
use fados\ChartjsBundle\Model\ChartBuiderData;
use fados\ChartjsBundle\Utils\TypeCharjs;
use fados\ChartjsBundle\Utils\TypeColors;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_internal_incident_frontend_home")
     * @param Request $request
     * @param FrontendControllerService $incidentFrontendController
     * @return array
     */
    public function homeAction(Request $request, FrontendControllerService $incidentFrontendController)
    {
        return $incidentFrontendController->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_internal_incident_frontend_new_incident")
     * @param Request $request
     * @return array
     */
    public function newIncidentAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    public function getFrontendController($incidentFrontendController = null)
    {
        return $incidentFrontendController;
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_internal_incident_frontend_edit_incident_id",requirements={"id"="\d+"})
     * @Route("{slug}/edit", name="cert_unlp_ngen_internal_incident_frontend_edit_incident")
     * @param Incident $incident
     * @return array
     */
    public function editIncidentAction(Incident $incident)
    {
        return $this->getFrontendController()->editEntity($incident);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_internal_incident_frontend_detail_incident_id",requirements={"id"="\d+"})
     * @Route("{slug}/detail", name="cert_unlp_ngen_internal_incident_frontend_detail_incident")
     * @param Incident $incident
     * @return array
     */
    public function detailIncidentAction(Incident $incident)
    {
        $response['object'] = $incident;
        $response['timeline'] = null;
//        $response['piechart_state'] = $this->makePieChart($incident->getStateRatio());
        $response['piechart_feed'] = $this->getFrontendController()->makePieChart($incident->getFeedRatio());
        $response['piechart_priority'] = $this->getFrontendController()->makePieChart($incident->getPriorityRatio());
        $response['piechart_tlp'] = $this->getFrontendController()->makePieChart($incident->getTlpRatio());
        if ($incident->getChangeStateHistory()->count() > 1) {
            $response['timeline'] = $this->getFrontendController()->makeTimeline($incident->getStateTimelineRatio());
        }
        $response['column_chart'] = $this->getFrontendController()->makeColumnChart($incident->getDateRatio());
        return $response;
    }


    /**
     * @Route("{id}/evidence", name="cert_unlp_ngen_internal_incident_frontend_evidence_incident_id", requirements={"id"="\d+"})
     * @Route("{slug}/evidence", name="cert_unlp_ngen_internal_incident_frontend_evidence_incident")
     * @param Incident $incident
     * @return BinaryFileResponse
     */
    public function evidenceIncidentAction(Incident $incident)
    {

        return $this->getFrontendController()->evidenceIncidentAction($incident);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_internal_incident_search_incident")
     * @param Request $request
     * @return array
     */
    public function searchIncidentAction(Request $request)

    {
        return $this->getFrontendController()->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentComments.html.twig")
     * @param Incident $incident
     * @param Request $request
     * @return array
     */
    public function incidentCommentsAction(Incident $incident, Request $request)
    {
        return $this->getFrontendController()->commentsEntity($incident, $request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/list/incidentListRow.html.twig")
     * @Route("{id}/getListRow", name="cert_unlp_ngen_incident_frontend_get_list_row_incident_id", requirements={"id"="\d+"})
     * @param Incident $incident
     * @return array
     */

    public function getListRow(Incident $incident)
    {
        return array('incident' => $incident);
    }

    /**
     * @Route("getFilterList", name="cert_unlp_ngen_incident_ajax_search_incident")
     * @param Request $request
     * @return JsonResponse
     */
    public function getFilterIncidentListAction(Request $request)

    {
        $datos = $this->getFrontendController()->homeEntity($request);
        $tabla = $this->renderView("CertUnlpNgenBundle:Incident:Frontend/list/filterList.html.twig", $datos);
        $paginador = $this->renderView("CertUnlpNgenBundle:Incident:Frontend/list/filterListPaginator.html.twig", $datos);
        $filters = $this->renderView("CertUnlpNgenBundle:Incident:Frontend/list/filterHeadersPaginator.html.twig", $datos);
        $indice = $datos['objects']->getPaginationData();
        return new JsonResponse(array('tabla' => $tabla, 'indice' => $indice, 'paginador' => $paginador, 'filters' => $filters));

    }
}
