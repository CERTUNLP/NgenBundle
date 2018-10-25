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

namespace CertUnlp\NgenBundle\Controller;

use CertUnlp\NgenBundle\Entity\IncidentFeed;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IncidentFeedFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_incident_feed_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.incident.feed.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_feed_search")
     * @param Request $request
     * @return array
     */
    public function searchIncidentFeedAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/incidentFeedForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_feed_new")
     * @param Request $request
     * @return array
     */
    public function newIncidentFeedAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/incidentFeedForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_feed_edit")
     * @param IncidentFeed $incidentFeed
     * @return array
     */
    public function editIncidentFeedAction(IncidentFeed $incidentFeed)
    {
        return $this->getFrontendController()->editEntity($incidentFeed);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/incidentFeedDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_feed_detail")
     * @param IncidentFeed $incidentFeed
     * @return array
     */
    public function detailIncidentFeedAction(IncidentFeed $incidentFeed)
    {
        return $this->getFrontendController()->detailEntity($incidentFeed);
    }

}
