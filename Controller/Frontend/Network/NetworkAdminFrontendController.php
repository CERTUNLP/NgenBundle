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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NetworkAdminFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_admin_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.network.admin.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin/Frontend:home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_search_network_admin")
     * @param Request $request
     * @return array
     */
    public function searchNetworkAdminAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Route("search/autocomplete", name="cert_unlp_ngen_network_admin_search_autocomplete")
     * @param Request $request
     * @return array
     */
    public function searchAutocompleteNetworkAdminAction(Request $request)
    {
        return $this->getFrontendController()->searchAutocompleteEntity($request);

    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_new_network_admin")
     * @param Request $request
     * @return array
     */
    public function newNetworkAdminAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_network_edit_network_admin")
     * @param NetworkAdmin $networkAdmin
     * @return array
     */
    public function editNetworkAdminAction(NetworkAdmin $networkAdmin)
    {
        return $this->getFrontendController()->editEntity($networkAdmin);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_network_detail_network_admin")
     * @param NetworkAdmin $networkAdmin
     * @return array
     */
    public function detailNetworkAdminAction(NetworkAdmin $networkAdmin)
    {
        return $this->getFrontendController()->detailEntity($networkAdmin);
    }

}
