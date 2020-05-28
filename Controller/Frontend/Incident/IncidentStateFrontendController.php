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

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Form\IncidentStateType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentStateFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_state_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_state
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_state): array
    {
        return $this->homeEntity($request, $elastica_finder_state);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_state_search")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_state
     * @return array
     */
    public function searchIncidentStateAction(Request $request, PaginatedFinderInterface $elastica_finder_state): array
    {
        return $this->searchEntity($request, $elastica_finder_state);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/incidentStateForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_state_new")
     * @param Request $request
     * @param IncidentStateType $state_type
     * @return array
     */
    public function newIncidentStateAction(Request $request, IncidentStateType $state_type): array
    {
        return $this->newEntity($request, $state_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/incidentStateForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_state_edit")
     * @param IncidentState $incidentState
     * @param IncidentStateType $state_type
     * @return array
     */
    public function editIncidentStateAction(IncidentState $incidentState, IncidentStateType $state_type): array
    {
        return $this->editEntity($incidentState, $state_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentState:Frontend/incidentStateDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_state_detail")
     * @param IncidentState $incidentState
     * @return array
     */
    public function detailIncidentStateAction(IncidentState $incidentState): array
    {
        return $this->detailEntity($incidentState);
    }

}
