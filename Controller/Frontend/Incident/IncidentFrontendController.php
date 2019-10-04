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
use CertUnlp\NgenBundle\Entity\Incident\IncidentChangeState;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Timeline;
use fados\ChartjsBundle\Model\ChartBuiderData;
use fados\ChartjsBundle\Utils\TypeCharjs;
use fados\ChartjsBundle\Utils\TypeColors;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IncidentFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_internal_incident_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.incident.internal.frontend.controller');
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
        $response['piechart_feed'] = $this->makePieChart($incident->getFeedRatio());
        $response['piechart_priority'] = $this->makePieChart($incident->getPriorityRatio());
        $response['piechart_tlp'] = $this->makePieChart($incident->getTlpRatio());
        if ($incident->getChangeStateHistory()->count() > 1) {
            $response['timeline'] = $this->makeTimeline($incident);
        }
        $response['column_chart'] = $this->makeColumnChart($incident);
        return $response;
    }

    /**
     * @param array $states
     * @return PieChart
     */
    public function makePieChart(array $states): PieChart
    {
        $pieChart = new PieChart();
//        var_dump($array);die;
        array_unshift($states, ['Task', 'Hours per Day']);
        $pieChart->getData()->setArrayToDataTable(
            $states
        );
        $pieChart->getOptions()->setHeight(150);
//        $pieChart->getOptions()->setWidth(200);
        $pieChart->getOptions()->setPieHole(0.5);
        $pieChart->getOptions()->getLegend()->setPosition('none');
        return $pieChart;
    }

    /**
     * @param Incident $incident
     * @return Timeline
     */
    public function makeTimeline(Incident $incident): Timeline
    {
        $states = [];
        $suffix = '';

        $states_changes = $incident->getChangeStateHistory()->filter(static function (IncidentChangeState $changeState) {
            return $changeState->getOldState()->getSlug() !== $changeState->getNewState()->getSlug();
        });
        if (!$states_changes->contains($incident->getChangeStateHistory()->first())) {
            $states_changes->set(0, $incident->getChangeStateHistory()->first());
        }
        if (!$states_changes->contains($incident->getChangeStateHistory()->last())) {
            $states_changes->add($incident->getChangeStateHistory()->last());
        }

        foreach ($states_changes as $detected) {
            if (isset($states[$detected->getOldState()->getName() . '-' . $suffix])) {
                $states[$detected->getOldState()->getName() . '-' . $suffix][3] = $detected->getDate();
            } elseif (isset($states[$detected->getOldState()->getName()])) {
                $states[$detected->getOldState()->getName()][3] = $detected->getDate();
            } else {
                $states[$detected->getOldState()->getName()] = ['state', $detected->getOldState()->getName(), $detected->getDate(), $detected->getDate()];
            }

            if (isset($states[$detected->getNewState()->getName()]) && $detected->getNewState()->getName() !== $detected->getOldState()->getName()) {
                $suffix++;
                $states[$detected->getNewState()->getName() . '-' . $suffix] = ['state', $detected->getNewState()->getName() . '-' . $suffix, $detected->getDate(), $detected->getDate()];
            } elseif ($detected->getNewState()->getName() === $detected->getOldState()->getName()) {
                $states[$detected->getOldState()->getName()][3] = $detected->getDate();
            } else {
                $states[$detected->getNewState()->getName()] = ['state', $detected->getNewState()->getName(), $detected->getDate(), $detected->getDate()];
            }
        }


        $timeline = new Timeline();
        $timeline->getOptions()->getTimeline()->setShowBarLabels(false);
        $timeline->getOptions()->getTimeline()->setShowRowLabels(false);
        $timeline->getOptions()->setHeight(91);
        $timeline->getData()->setArrayToDataTable(
            $states, true

        );
        return $timeline;
    }

    /**
     * @param Incident $incident
     * @return ColumnChart
     */
    public function makeColumnChart(Incident $incident): ColumnChart
    {
        $col = new ColumnChart();

        $ratio = [];
        foreach ($incident->getIncidentsDetected() as $detected) {
            if (isset($ratio[$detected->getDate()->format('d-m')])) {
                $ratio[$detected->getDate()->format('d-m')]++;
            } else {
                $ratio[$detected->getDate()->format('d-m')] = 1;
            }
        }
        if (isset($ratio[$incident->getCreatedAt()->format('d-m')])) {
            $ratio[$incident->getCreatedAt()->format('d-m')]++;
        } else {
            $ratio[$incident->getCreatedAt()->format('d-m')] = 1;
        }
        $percentages = [];
        foreach ($ratio as $key => $value) {
            $percentages[] = [$key, $value];
        }
        array_unshift($percentages, ['Days', 'Detections per Day']);

        $col->getData()->setArrayToDataTable(
            $percentages
        );
        $col->getOptions()->setTitle('Detections: ' . ($incident->getLtdCount() + 1));
        $col->getOptions()->getLegend()->setPosition('none');
        $col->getOptions()->getAnnotations()->setAlwaysOutside(true);
        return $col;
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
