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

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_admin_frontend_home")
     */
    public function homeAction(Request $request) {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT na "
                . "FROM CertUnlpNgenBundle:NetworkAdmin na";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->query->get('page', 1), 7
                , array('defaultSortFieldName' => 'na.name', 'defaultSortDirection' => 'asc')
        );

        return array('networkAdmins' => $pagination);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_new_network_admin")
     */
    public function newNetworkAdminAction(Request $request) {
        return array('form' => $this->createForm(new NetworkAdminType()), 'method' => 'POST');
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_network_edit_network_admin")
     */
    public function editNetworkAdminAction(NetworkAdmin $networkAdmin) {
        return array('form' => $this->createForm(new NetworkAdminType(), $networkAdmin), 'method' => 'PATCH');
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/networkAdminDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_network_detail_network_admin")
     */
    public function datailNetworkAdminAction(NetworkAdmin $networkAdmin) {
        return array('networkAdmin' => $networkAdmin);
    }

    /**
     * @Template("CertUnlpNgenBundle:NetworkAdmin:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_network_search_network_admin")
     */
    public function searchNetworkAdminAction(Request $request) {
        $finder = $this->container->get('fos_elastica.finder.networks.network');

        $results = $finder->find($request->get('term'));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $results, $request->query->get('page', 1), 7
                , array('defaultSortFieldName' => 'i.createdAt', 'defaultSortDirection' => 'desc')
        );

        $pagination->setParam('term', $request->get('term'));

        return array('networkAdmins' => $pagination, 'term' => $request->get('term'));
    }

}
