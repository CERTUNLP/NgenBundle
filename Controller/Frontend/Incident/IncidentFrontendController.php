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

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Form\IncidentSearchType;
use CertUnlp\NgenBundle\Form\IncidentType;
use fados\ChartjsBundle\Model\ChartBuiderData;
use fados\ChartjsBundle\Utils\TypeCharjs;
use fados\ChartjsBundle\Utils\TypeColors;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ZipArchive;

class IncidentFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_internal_incident_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_incident
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_incident): array
    {
        return $this->homeEntity($request, $elastica_finder_incident);
    }

    /**
     * {@inheritDoc}
     */
    public function homeEntity(Request $request, PaginatedFinderInterface $finder, string $term = '', int $limit = 7, string $defaultSortFieldName = 'createdAt', string $defaultSortDirection = 'desc'): array
    {
        if (!$term) {
            $term = $request->get('term') ?: '*';
        }
        $quickSearchForm = $this->getFormFactory()->createBuilder(IncidentSearchType::class, (new Incident), array('csrf_protection' => true));
        return array('objects' => $this->searchEntity($request, $finder,$term, $limit, $defaultSortFieldName, $defaultSortDirection, 'pageobject', 'object')['objects'], 'search_form' => $quickSearchForm->getForm()->createView());

    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_internal_incident_frontend_new_incident")
     * @param Request $request
     * @param IncidentType $incident_type
     * @return array
     */
    public function newIncidentAction(Request $request, IncidentType $incident_type): array
    {
        return $this->newEntity($request, $incident_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_internal_incident_frontend_edit_incident_id",requirements={"id"="\d+"})
     * @Route("{slug}/edit", name="cert_unlp_ngen_internal_incident_frontend_edit_incident")
     * @param Incident $incident
     * @param IncidentType $incident_type
     * @return array
     */
    public function editIncidentAction(Incident $incident, IncidentType $incident_type): array
    {
        return $this->editEntity($incident, $incident_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_internal_incident_frontend_detail_incident_id",requirements={"id"="\d+"})
     * @Route("{slug}/detail", name="cert_unlp_ngen_internal_incident_frontend_detail_incident")
     * @param Incident $incident
     * @return array
     */
    public function detailIncidentAction(Incident $incident): array
    {
        $response['object'] = $incident;
        $response['timeline'] = null;
//        $response['piechart_state'] = $this->makePieChart($incident->getStateRatio());
        $response['piechart_feed'] = $this->makePieChart($incident->getFeedRatio());
        $response['piechart_priority'] = $this->makePieChart($incident->getPriorityRatio());
        $response['piechart_tlp'] = $this->makePieChart($incident->getTlpRatio());
        if ($incident->getStatechanges()->count() > 1) {
            $response['timeline'] = $this->makeTimeline($incident->getStateTimelineRatio());
        }
        $response['column_chart'] = $this->makeColumnChart($incident->getDateRatio());
        return $response;
    }

    /**
     * @Route("{id}/evidence", name="cert_unlp_ngen_internal_incident_frontend_evidence_incident_id", requirements={"id"="\d+"})
     * @Route("{slug}/evidence", name="cert_unlp_ngen_internal_incident_frontend_evidence_incident")
     * @param Incident $incident
     * @param string $evidence_path
     * @return Response
     */
    public function evidenceIncidentAction(Incident $incident, string $evidence_path): Response
    {
        $zip = new ZipArchive();

        // The name of the Zip documents.
        $evidence_directory = $evidence_path . $incident->getEvidenceSubDirectory() . '/';
        $zipName = $evidence_directory . 'EvidenceDocuments' . $incident->getSlug() . '.zip';
//        $options = array('remove_all_path' => TRUE);
        $zip->open($zipName, ZipArchive::CREATE);
        foreach ($incident->getIncidentsDetected() as $detected) {
            if ($detected->getEvidenceFilePath()) {
                $zip->addFile($evidence_path . $detected->getEvidenceFilePath(), $detected->getEvidenceFilePath());
            }
        }
        //$zip->addGlob($evidence_path . "*", GLOB_BRACE, $options);
        $zip->close();
        $response = new Response(file_get_contents($zipName));
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $zipName . '"');
        $response->headers->set('Content-length', filesize($zipName));

        @unlink($zipName);

        return $response;
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_internal_incident_search_incident")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_incident
     * @return array
     */
    public function searchIncidentAction(Request $request, PaginatedFinderInterface $elastica_finder_incident): array
    {
        return $this->homeEntity($request, $elastica_finder_incident);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentComments.html.twig")
     * @param Incident $incident
     * @param Request $request
     * @param ThreadManagerInterface $thread_manager
     * @param CommentManagerInterface $comment_manager
     * @return array
     */
    public function incidentCommentsAction(Incident $incident, Request $request, ThreadManagerInterface $thread_manager, CommentManagerInterface $comment_manager): array
    {
        $id = $incident->getId();
        $thread = $thread_manager->findThreadById($id);
        if (null === $thread) {
            $thread = $thread_manager->createThread();
            $thread->setId($id);
            $incident->setCommentThread($thread);
            $thread->setIncident($incident);
            $thread->setPermalink($request->getUri());
            $thread_manager->saveThread($thread);
        }
        $comments = $comment_manager->findCommentTreeByThread($thread);
        return array(
            'comments' => $comments,
            'thread' => $thread,
        );
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
     * @param PaginatedFinderInterface $elastica_finder_incident
     * @return JsonResponse
     */
    public function getFilterIncidentListAction(Request $request, PaginatedFinderInterface $elastica_finder_incident): JsonResponse
    {
        $datos = $this->homeEntity($request, $elastica_finder_incident);
        $tabla = $this->renderView("CertUnlpNgenBundle:Incident:Frontend/list/filterList.html.twig", $datos);
        $paginador = $this->renderView("CertUnlpNgenBundle:Incident:Frontend/list/filterListPaginator.html.twig", $datos);
        $filters = $this->renderView("CertUnlpNgenBundle:Incident:Frontend/list/filterHeadersPaginator.html.twig", $datos);
        $indice = $datos['objects']->getPaginationData();
        return new JsonResponse(array('tabla' => $tabla, 'indice' => $indice, 'paginador' => $paginador, 'filters' => $filters));
    }
}
