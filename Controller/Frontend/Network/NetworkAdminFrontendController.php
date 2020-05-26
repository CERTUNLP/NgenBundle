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

namespace CertUnlp\NgenBundle\Controller\Frontend\Network;

use CertUnlp\NgenBundle\Entity\Network\NetworkAdmin;
use CertUnlp\NgenBundle\Service\Frontend\Controller\FrontendControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NetworkAdminFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_admin_frontend_home")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->homeEntity($request);
    }


    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin/Frontend:home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_search_network_admin")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function searchNetworkAdminAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->searchEntity($request);
    }

    /**
     * @Route("search/autocomplete", name="cert_unlp_ngen_network_admin_search_autocomplete")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return JsonResponse
     */
    public function searchAutocompleteNetworkAdminAction(Request $request, FrontendControllerService $controller_service): JsonResponse
    {
        return $controller_service->searchAutocompleteEntity($request);

    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_new_network_admin")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function newNetworkAdminAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_network_edit_network_admin")
     * @param NetworkAdmin $networkAdmin
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function editNetworkAdminAction(NetworkAdmin $networkAdmin, FrontendControllerService $controller_service): array
    {
        return $controller_service->editEntity($networkAdmin);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_network_detail_network_admin")
     * @param NetworkAdmin $networkAdmin
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function detailNetworkAdminAction(NetworkAdmin $networkAdmin, FrontendControllerService $controller_service): array
    {
        return $controller_service->detailEntity($networkAdmin);
    }

}
