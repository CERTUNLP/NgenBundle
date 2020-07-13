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

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Form\Incident\IncidentTypeType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IncidentTypeFrontendController extends FrontendController
{
    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_type_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_type
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_type): array
    {
        return $this->homeEntity($request, $elastica_finder_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_type_search")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_type
     * @return array
     */
    public function searchIncidentTypeAction(Request $request, PaginatedFinderInterface $elastica_finder_type): array
    {
        return $this->searchEntity($request, $elastica_finder_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_type_new")
     * @param IncidentTypeType $type
     * @return array
     */
    public function newIncidentTypeAction(IncidentTypeType $type): array
    {
        return $this->newEntity($type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_type_edit")
     * @param IncidentType $incidentType
     * @param IncidentTypeType $type
     * @return array
     */
    public function editIncidentTypeAction(IncidentType $incidentType, IncidentTypeType $type): array
    {
        return $this->editEntity($incidentType, $type);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_type_detail")
     * @param IncidentType $incidentType
     * @return array
     */
    public function detailIncidentTypeAction(IncidentType $incidentType): array
    {
        return $this->detailEntity($incidentType);
    }

}
