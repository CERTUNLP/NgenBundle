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

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Incident\IncidentFeed;
use CertUnlp\NgenBundle\Form\IncidentFeedType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentFeedFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_feed_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_feed
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_feed): array
    {
        return $this->homeEntity($request, $elastica_finder_feed);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_feed_search")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_feed
     * @return array
     */
    public function searchIncidentFeedAction(Request $request, PaginatedFinderInterface $elastica_finder_feed): array
    {
        return $this->searchEntity($request, $elastica_finder_feed);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/incidentFeedForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_feed_new")
     * @param Request $request
     * @param IncidentFeedType $type
     * @return array
     */
    public function newIncidentFeedAction(Request $request, IncidentFeedType $type): array
    {
        return $this->newEntity($request, $type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/incidentFeedForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_feed_edit")
     * @param IncidentFeed $incident_feed
     * @param IncidentFeedType $type
     * @return array
     */
    public function editIncidentFeedAction(IncidentFeed $incident_feed, IncidentFeedType $type): array
    {
        return $this->editEntity($incident_feed, $type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentFeed:Frontend/incidentFeedDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_feed_detail")
     * @param IncidentFeed $incident_feed
     * @return array
     */
    public function detailIncidentFeedAction(IncidentFeed $incident_feed): array
    {
        return $this->detailEntity($incident_feed);
    }

}
