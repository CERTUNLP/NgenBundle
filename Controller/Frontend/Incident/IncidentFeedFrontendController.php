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
 * Description of IncidentFeedFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Service\Frontend\Controller\FrontendControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentFeedFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_feed_frontend_home")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_feed_search")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function searchIncidentFeedAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/incidentFeedForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_feed_new")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function newIncidentFeedAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/incidentFeedForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_feed_edit")
     * @param IncidentFeed $incidentFeed
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function editIncidentFeedAction(IncidentFeed $incidentFeed, FrontendControllerService $controller_service): array
    {
        return $controller_service->editEntity($incidentFeed);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/incidentFeedDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_feed_detail")
     * @param IncidentFeed $incidentFeed
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function detailIncidentFeedAction(IncidentFeed $incidentFeed, FrontendControllerService $controller_service): array
    {
        return $controller_service->detailEntity($incidentFeed);
    }

}
