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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return $this->getFrontendController()->detailEntity($incident);
    }

    /**
     * @Route("{id}/evidence", name="cert_unlp_ngen_internal_incident_frontend_evidence_incident_id", requirements={"id"="\d+"})
     * @Route("{slug}/evidence", name="cert_unlp_ngen_internal_incident_frontend_evidence_incident")
     * @param Incident $incident
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
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
        return $this->getFrontendController()->searchEntity($request);
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

}
