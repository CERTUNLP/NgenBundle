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
 * Description of IncidentTypeFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Service\Frontend\Controller\FrontendControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentTypeFrontendController extends Controller
{
    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_type_frontend_home")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_type_search")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function searchIncidentTypeAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_type_new")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function newIncidentTypeAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_type_edit")
     * @param IncidentType $incidentType
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function editIncidentTypeAction(IncidentType $incidentType, FrontendControllerService $controller_service): array
    {
        return $controller_service->editEntity($incidentType);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_type_detail")
     * @param IncidentType $incidentType
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function detailIncidentTypeAction(IncidentType $incidentType, FrontendControllerService $controller_service): array
    {
        return $controller_service->detailEntity($incidentType);
    }

}
