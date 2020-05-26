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
 * Description of IncidentPriorityFrontendController
 *
 * @author einar
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use CertUnlp\NgenBundle\Service\Frontend\Controller\FrontendControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentPriorityFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentPriority:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_incident_priority_frontend_home")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, FrontendControllerService $controller_service)
    {
        return $controller_service->homeEntity($request, null, 10, 'code', 'asc');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentPriority:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_priority_search")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function searchIncidentPriorityAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentPriority:Frontend/incidentPriorityForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_priority_new")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function newIncidentPriorityAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentPriority:Frontend/incidentPriorityForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_incident_priority_edit")
     * @param IncidentPriority $IncidentPriority
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function editIncidentPriorityAction(IncidentPriority $IncidentPriority, FrontendControllerService $controller_service): array
    {
        return $controller_service->editEntity($IncidentPriority);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentPriority:Frontend/incidentPriorityDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_incident_priority_detail")
     * @param IncidentPriority $IncidentPriority
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function detailIncidentPriorityAction(IncidentPriority $IncidentPriority, FrontendControllerService $controller_service): array
    {
        return $controller_service->detailEntity($IncidentPriority);
    }

}
