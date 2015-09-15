<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use CertUnlp\NgenBundle\Entity\Incident;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CertUnlp\NgenBundle\Form\IncidentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IncidentFrontendController extends Controller {

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_incident_frontend_home")
     */
    public function homeAction(Request $request) {

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT i,s,f,t "
                . "FROM CertUnlpNgenBundle:Incident i join i.state s inner join i.feed f join i.type t "
//                . "WHERE s.slug = 'open' and i.isClosed = false"
                ;
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->query->get('page', 1), 7
                , array('defaultSortFieldName' => 'i.createdAt', 'defaultSortDirection' => 'desc')
        );

        return array('incidents' => $pagination);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_new_incident")
     */
    public function newIncidentAction(Request $request) {
        return array('form' => $this->createForm(new IncidentType()), 'method' => 'POST');
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentForm.html.twig")
     * @Route("{hostAddress}/{date}/{type}/edit", name="cert_unlp_ngen_incident_edit_incident")
     * @ParamConverter("incident", class="CertUnlpNgenBundle:Incident", options={"repository_method" = "findByHostDateType"})

     */
    public function editIncidentAction(Incident $incident) {
        return array('form' => $this->createForm(new IncidentType(), $incident), 'method' => 'patch');
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentDetail.html.twig")
     * @Route("{hostAddress}/{date}/{type}/detail", name="cert_unlp_ngen_incident_detail_incident")
     * @ParamConverter("incident", class="CertUnlpNgenBundle:Incident", options={"repository_method" = "findByHostDateType"})

     */
    public function datailIncidentAction(Incident $incident) {
        return array('incident' => $incident);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_search_incident")
     */
    public function searchIncidentAction(Request $request) {
        $finder = $this->container->get('fos_elastica.finder.incidents.incident');

        $results = $finder->find($request->get('term'));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $results, $request->query->get('page', 1), 7
                , array('defaultSortFieldName' => 'i.createdAt', 'defaultSortDirection' => 'desc')
        );
        return array('incidents' => $results, 'incidents' => $pagination, 'term' => $request->get('term'));
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentComments.html.twig")
     */
    public function incidentCommentsAction(Incident $incident, Request $request) {
        $id = $incident->getId();
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setIncident($incident);
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }

        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);

        return array(
            'comments' => $comments,
            'thread' => $thread,
        );
    }

}
