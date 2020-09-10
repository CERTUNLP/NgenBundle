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

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Incident\IncidentPriority;
use CertUnlp\NgenBundle\Form\Incident\IncidentPriorityType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentPriorityFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentPriority:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_incident_priority_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_priority
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_priority): array
    {
        return $this->homeEntity($request, $elastica_finder_priority, '', 10, 'code', 'asc');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentPriority:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_priority_search")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_priority
     * @return array
     */
    public function searchIncidentPriorityAction(Request $request, PaginatedFinderInterface $elastica_finder_priority): array
    {
        return $this->searchEntity($request, $elastica_finder_priority);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentPriority:Frontend/incidentPriorityForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_priority_new")
     * @param IncidentPriorityType $priority_type
     * @return array
     */
    public function newIncidentPriorityAction(IncidentPriorityType $priority_type): array
    {
        return $this->newEntity($priority_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentPriority:Frontend/incidentPriorityForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_incident_priority_edit",requirements={"id"="\d+"})
     * @param IncidentPriority $IncidentPriority
     * @param IncidentPriorityType $priority_type
     * @return array
     */
    public function editIncidentPriorityAction(IncidentPriority $IncidentPriority, IncidentPriorityType $priority_type): array
    {
        return $this->editEntity($IncidentPriority, $priority_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentPriority:Frontend/incidentPriorityDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_incident_priority_detail",requirements={"id"="\d+"})
     * @param IncidentPriority $IncidentPriority
     * @return array
     */
    public function detailIncidentPriorityAction(IncidentPriority $IncidentPriority): array
    {
        return $this->detailEntity($IncidentPriority);
    }

}
