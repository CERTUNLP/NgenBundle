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
 * Description of NetworkAdminFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Constituency;

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Entity\Constituency\NetworkAdmin;
use CertUnlp\NgenBundle\Form\Constituency\NetworkAdminType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NetworkAdminFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_admin_frontend_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_network_admin
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_network_admin): array
    {
        return $this->homeEntity($request, $elastica_finder_network_admin);
    }


    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin/Frontend:home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_search_network_admin")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_network_admin
     * @return array
     */
    public function searchNetworkAdminAction(Request $request, PaginatedFinderInterface $elastica_finder_network_admin): array
    {
        return $this->searchEntity($request, $elastica_finder_network_admin);
    }

    /**
     * @Route("search/autocomplete", name="cert_unlp_ngen_network_admin_search_autocomplete")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_network_admin
     * @return JsonResponse
     */
    public function searchAutocompleteNetworkAdminAction(Request $request, PaginatedFinderInterface $elastica_finder_network_admin): JsonResponse
    {
        return $this->searchAutocompleteEntity($request, $elastica_finder_network_admin);

    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_new_network_admin")
     * @param NetworkAdminType $admin_type
     * @return array
     */
    public function newNetworkAdminAction(NetworkAdminType $admin_type): array
    {
        return $this->newEntity($admin_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_network_edit_network_admin_id",requirements={"id"="\d+"})
     * @Route("{slug}/edit", name="cert_unlp_ngen_network_edit_network_admin_slug")
     * @param NetworkAdmin $network_admin
     * @param NetworkAdminType $admin_type
     * @return array
     */
    public function editNetworkAdminAction(NetworkAdmin $network_admin, NetworkAdminType $admin_type): array
    {
        return $this->editEntity($network_admin, $admin_type);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_network_detail_network_admin_id",requirements={"id"="\d+"})
     * @Route("{slug}/detail", name="cert_unlp_ngen_network_detail_network_admin_slug")
     * @param NetworkAdmin $network_admin
     * @return array
     */
    public function detailNetworkAdminAction(NetworkAdmin $network_admin): array
    {
        return $this->detailEntity($network_admin);
    }

}
