<?php

/*
 * This file is part of the Ngen - CSIRT Network Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Network;

use CertUnlp\NgenBundle\Entity\Network\Network;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NetworkFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.network.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_search_network")
     * @param Request $request
     * @return array
     */
    public function searchNetworkAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_new_network")
     * @param Request $request
     * @return array
     */
    public function newNetworkAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkForm.html.twig")
     * @Route("{domain}/edit", name="cert_unlp_ngen_network_edit_network_domain",requirements={"domain"="^(?:[-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,20}$"} )
     * @Route("{ip_v4}/{ip_v4_mask}/edit", name="cert_unlp_ngen_network_edit_network_ip_v4", requirements={"ip_v4"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$"} )
     * @Route("{ip_v6}/{ip_v6_mask}/edit", name="cert_unlp_ngen_network_edit_network_ip_v6")
     * @param Network $network
     * @return array
     */
    public function editNetworkAction(Network $network)
    {
        return $this->getFrontendController()->editEntity($network);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkDetail.html.twig")
     * @Route("{domain}/detail", name="cert_unlp_ngen_network_detail_network_domain",requirements={"domain"="^(?:[-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,20}$"} )
     * @Route("{ip_v4}/{ip_v4_mask}/detail", name="cert_unlp_ngen_network_detail_network_ip_v4", requirements={"ip_v4"="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$"} )
     * @Route("{ip_v6}/{ip_v6_mask}/detail", name="cert_unlp_ngen_network_detail_network_ip_v6")
     * @param Network $network
     * @return array
     */
    public function datailNetworkAction(Network $network)
    {
        return $this->getFrontendController()->detailEntity($network);
    }

}
