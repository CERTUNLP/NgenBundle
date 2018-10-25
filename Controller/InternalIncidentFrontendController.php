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

use CertUnlp\NgenBundle\Form\InternalIncident;
use CertUnlp\NgenBundle\Model\IncidentInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InternalIncidentFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:InternalIncident:Frontend/home.html.twig")
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
     * @Template("CertUnlpNgenBundle:InternalIncident:Frontend/incidentForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_internal_incident_frontend_new_incident")
     * @param Request $request
     * @return array
     */
    public function newIncidentAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:InternalIncident:Frontend/incidentForm.html.twig")
     * @Route("{hostAddress}/{date}/{type}/edit", name="cert_unlp_ngen_internal_incident_frontend_edit_incident")
     * @ParamConverter("incident", class="CertUnlpNgenBundle:InternalIncident", options={"repository_method" = "findByHostDateType"})
     * @param IncidentInterface $incident
     * @return array
     */
    public function editIncidentAction(IncidentInterface $incident)
    {
        return $this->getFrontendController()->editEntity($incident);
    }

    /**
     * @Template("CertUnlpNgenBundle:InternalIncident:Frontend/incidentDetail.html.twig")
     * @Route("{hostAddress}/{date}/{type}/detail", name="cert_unlp_ngen_internal_incident_frontend_detail_incident")
     * @ParamConverter("incident", class="CertUnlpNgenBundle:InternalIncident", options={"repository_method" = "findByHostDateType"})
     * @param IncidentInterface $incident
     * @return array
     */
    public function detailIncidentAction(IncidentInterface $incident)
    {
        return $this->getFrontendController()->detailEntity($incident);
    }

    /**
     * @Route("{hostAddress}/{date}/{type}/evidence", name="cert_unlp_ngen_internal_incident_frontend_evidence_incident")
     * @ParamConverter("incident", class="CertUnlpNgenBundle:InternalIncident", options={"repository_method" = "findByHostDateType"})
     * @param IncidentInterface $incident
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function evidenceIncidentAction(IncidentInterface $incident)
    {

        return $this->getFrontendController()->evidenceIncidentAction($incident);
    }

    /**
     * @Template("CertUnlpNgenBundle:InternalIncident:Frontend/home.html.twig")
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
     * @param IncidentInterface $incident
     * @param Request $request
     * @return array
     */
    public function incidentCommentsAction(IncidentInterface $incident, Request $request)
    {
        return $this->getFrontendController()->commentsEntity($incident, $request);
    }

}
