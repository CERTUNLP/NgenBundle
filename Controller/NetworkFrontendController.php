<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
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

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_frontend_home")
     */
    public function homeAction(Request $request) {
        $networks = $this->getDoctrine()
                ->getRepository('CertUnlpNgenBundle:Network')
                ->findBy(array(), array('ip' => 'desc'));
//        $flash = $this->get('braincrafted_bootstrap.flash');
//        $flash->danger('This is an alert flash message.');
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT n,au,na "
                . "FROM CertUnlpNgenBundle:Network n join n.academicUnit au join n.networkAdmin na";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->query->get('page', 1), 10
                , array('defaultSortFieldName' => 'n.ip', 'defaultSortDirection' => 'asc')
        );

        return array('networks' => $networks, 'pagination' => $pagination);
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_network_new_network")
     */
    public function newNetworkAction(Request $request) {
        return array('form' => $this->createForm(new NetworkType()), 'method' => 'POST');
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkForm.html.twig")
     * @Route("{ip}/{ipMask}/edit", name="cert_unlp_ngen_network_edit_network")
     */
    public function editNetworkAction(Network $network) {
        return array('form' => $this->createForm(new NetworkType(), $network), 'method' => 'PATCH');
    }

    /**
     * @Template("CertUnlpNgenBundle:Network:Frontend/networkDetail.html.twig")
     * @Route("{ip}/{ipMask}/detail", name="cert_unlp_ngen_network_detail_network")
     */
    public function datailNetworkAction(Network $network) {
        return array('network' => $network);
    }

}
