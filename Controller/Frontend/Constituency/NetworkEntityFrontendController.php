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
 * Description of NetworkEntityFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Constituency;

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkEntity;
use CertUnlp\NgenBundle\Form\Constituency\NetworkEntityType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NetworkEntityFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_network_entity_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_network_entity
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_network_entity): array
    {
        return $this->homeEntity($request, $elastica_finder_network_entity);
    }

    /**
     * @Route("search/autocomplete", name="cert_unlp_ngen_network_entity_search_autocomplete")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_network_entity
     * @return JsonResponse
     */
    public function searchAutocompleteNetworkAdminAction(Request $request, PaginatedFinderInterface $elastica_finder_network_entity): JsonResponse
    {
        return $this->searchAutocompleteEntity($request, $elastica_finder_network_entity);

    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_entity_search")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_network_entity
     * @return array
     */
    public function searchNetworkEntityAction(Request $request, PaginatedFinderInterface $elastica_finder_network_entity): array
    {
        return $this->searchEntity($request, $elastica_finder_network_entity);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/networkEntityForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_entity_new")
     * @param NetworkEntityType $entity_type
     * @return array
     */
    public function newNetworkEntityAction(NetworkEntityType $entity_type): array
    {
        return $this->newEntity($entity_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/networkEntityForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_network_entity_edit")
     * @param NetworkEntity $network_entity
     * @param NetworkEntityType $entity_type
     * @return array
     */
    public function editNetworkEntityAction(NetworkEntity $network_entity, NetworkEntityType $entity_type): array
    {
        return $this->editEntity($network_entity, $entity_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/networkEntityDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_network_entity_detail")
     * @param NetworkEntity $network_entity
     * @return array
     */
    public function detailNetworkEntityAction(NetworkEntity $network_entity): array
    {
        return $this->detailEntity($network_entity);
    }

}
