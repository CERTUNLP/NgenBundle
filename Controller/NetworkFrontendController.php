<?php

/*
 * This file is part of the Ngen - CSIRT Network Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CertUnlp\NgenBundle\Form\NetworkType;
use CertUnlp\NgenBundle\Entity\Network;

class NetworkFrontendController extends Controller {

    public function getFrontendController() {
        return $this->get('cert_unlp.ngen.network.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_frontend_home")
     */
    public function homeAction(Request $request) {
        return $this->getFrontendController()->homeEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_search_network")
     */
    public function searchNetworkAction(Request $request) {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_new_network")
     */
    public function newNetworkAction(Request $request) {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkForm.html.twig")
     * @Route("{ip}/{ipMask}/edit", name="cert_unlp_ngen_network_edit_network")
     */
    public function editNetworkAction(Network $network) {
        return $this->getFrontendController()->editEntity($network);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkDetail.html.twig")
     * @Route("{ip}/{ipMask}/detail", name="cert_unlp_ngen_network_detail_network")
     */
    public function datailNetworkAction(Network $network) {
        return $this->getFrontendController()->detailEntity($network);
    }

}
