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

namespace CertUnlp\NgenBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CertUnlp\NgenBundle\Form\NetworkAdminType;
use CertUnlp\NgenBundle\Entity\NetworkAdmin;

class NetworkAdminFrontendController extends Controller {

    public function getFrontendController() {
        return $this->get('cert_unlp.ngen.network.admin.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_admin_frontend_home")
     */
    public function homeAction(Request $request) {
        return $this->getFrontendController()->homeEntity($request, 'NetworkAdmin');
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_search_network_admin")
     */
    public function searchNetworkAdminAction(Request $request) {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_new_network_admin")
     */
    public function newNetworkAdminAction(Request $request) {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_network_edit_network_admin")
     */
    public function editNetworkAdminAction(NetworkAdmin $networkAdmin) {
        return $this->getFrontendController()->editEntity($networkAdmin);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_network_detail_network_admin")
     */
    public function detailNetworkAdminAction(NetworkAdmin $networkAdmin) {
        return $this->getFrontendController()->detailEntity($networkAdmin);
    }

}
