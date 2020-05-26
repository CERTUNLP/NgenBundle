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
 * Description of IncidentStateFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Service\Frontend\Controller\FrontendControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentStateFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_state_frontend_home")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_state_search")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function searchIncidentStateAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/incidentStateForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_state_new")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function newIncidentStateAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/incidentStateForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_state_edit")
     * @param IncidentState $incidentState
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function editIncidentStateAction(IncidentState $incidentState, FrontendControllerService $controller_service): array
    {
        return $controller_service->editEntity($incidentState);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/incidentStateDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_state_detail")
     * @param IncidentState $incidentState
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function detailIncidentStateAction(IncidentState $incidentState, FrontendControllerService $controller_service): array
    {
        return $controller_service->detailEntity($incidentState);
    }

}
