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

use CertUnlp\NgenBundle\Entity\ExternalIncident;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExternalIncidentFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:ExternalIncident:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_external_incident_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {

        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.incident.external.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:ExternalIncident:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_external_incident_search_incident")
     * @param Request $request
     * @return array
     */
    public function searchIncidentAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:ExternalIncident:Frontend/incidentForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_external_incident_frontend_new_incident")
     * @param Request $request
     * @return array
     */
    public function newIncidentAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:ExternalIncident:Frontend/incidentForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_external_incident_frontend_edit_incident_id",requirements={"id"="\d+"})
     * @Route("{slug}/edit", name="cert_unlp_ngen_external_incident_frontend_edit_incident")
     * @param ExternalIncident $incident
     * @return array
     */
    public function editIncidentAction(ExternalIncident $incident)
    {
        return $this->getFrontendController()->editEntity($incident);
    }

    /**
     * @Template("CertUnlpNgenBundle:ExternalIncident:Frontend/incidentDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_external_incident_frontend_detail_incident_id",requirements={"id"="\d+"})
     * @Route("{slug}/detail", name="cert_unlp_ngen_external_incident_frontend_detail_incident")
     * @param ExternalIncident $incident
     * @return array
     */
    public function datailIncidentAction(ExternalIncident $incident)
    {
        return $this->getFrontendController()->detailEntity($incident);
    }

    /**
     * @Route("{id}/evidence", name="cert_unlp_ngen_external_incident_frontend_evidence_incident_id",requirements={"id"="\d+"})
     * @Route("{slug}/evidence", name="cert_unlp_ngen_external_incident_frontend_evidence_incident")
     * @param ExternalIncident $incident
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function evidenceIncidentAction(ExternalIncident $incident)
    {

        return $this->getFrontendController()->evidenceIncidentAction($incident);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentComments.html.twig")
     * @param ExternalIncident $incident
     * @param Request $request
     * @return array
     */
    public function incidentCommentsAction(ExternalIncident $incident, Request $request)
    {
        return $this->getFrontendController()->commentsEntity($incident, $request);
    }

}
