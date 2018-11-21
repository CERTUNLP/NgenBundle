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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NetworkEntityFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_network_entity_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.network_entity.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_entity_search")
     * @param Request $request
     * @return array
     */
    public function searchNetworkEntityAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/networkEntityForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_entity_new")
     * @param Request $request
     * @return array
     */
    public function newNetworkEntityAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/networkEntityForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_network_entity_edit")
     * @param NetworkEntity $networkEntity
     * @return array
     */
    public function editNetworkEntityAction(NetworkEntity $networkEntity)
    {
        return $this->getFrontendController()->editEntity($networkEntity);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkEntity:Frontend/networkEntityDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_network_entity_detail")
     * @param NetworkEntity $networkEntity
     * @return array
     */
    public function detailNetworkEntityAction(NetworkEntity $networkEntity)
    {
        return $this->getFrontendController()->detailEntity($networkEntity);
    }

}
