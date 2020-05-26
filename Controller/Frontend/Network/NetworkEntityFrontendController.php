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

namespace CertUnlp\NgenBundle\Controller\Frontend\Network;

use CertUnlp\NgenBundle\Entity\Network\NetworkEntity;
use CertUnlp\NgenBundle\Service\Frontend\Controller\FrontendControllerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NetworkEntityFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_network_entity_frontend_home")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function homeAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->homeEntity($request);
    }

    /**
     * @Route("search/autocomplete", name="cert_unlp_ngen_network_entity_search_autocomplete")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return JsonResponse
     */
    public function searchAutocompleteNetworkAdminAction(Request $request, FrontendControllerService $controller_service): JsonResponse
    {
        return $controller_service->searchAutocompleteEntity($request);

    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_entity_search")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function searchNetworkEntityAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/networkEntityForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_entity_new")
     * @param Request $request
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function newNetworkEntityAction(Request $request, FrontendControllerService $controller_service): array
    {
        return $controller_service->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/networkEntityForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_network_entity_edit")
     * @param NetworkEntity $networkEntity
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function editNetworkEntityAction(NetworkEntity $networkEntity, FrontendControllerService $controller_service): array
    {
        return $controller_service->editEntity($networkEntity);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/networkEntityDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_network_entity_detail")
     * @param NetworkEntity $networkEntity
     * @param FrontendControllerService $controller_service
     * @return array
     */
    public function detailNetworkEntityAction(NetworkEntity $networkEntity, FrontendControllerService $controller_service): array
    {
        return $controller_service->detailEntity($networkEntity);
    }

}
