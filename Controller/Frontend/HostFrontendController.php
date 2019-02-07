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
 * Description of HostFrontendController
 *
 * @author einar
 */

namespace CertUnlp\NgenBundle\Controller\Frontend;

use CertUnlp\NgenBundle\Entity\Network\Host\Host;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HostFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:Host:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_host_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.host.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:Host:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_host_search")
     * @param Request $request
     * @return array
     */
    public function searchHostAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Host:Frontend/hostForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_host_new")
     * @param Request $request
     * @return array
     */
    public function newHostAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:Host:Frontend/hostForm.html.twig")
     * @Route("{id}/edit", name="cert_unlp_ngen_host_edit")
     * @param Host $host
     * @return array
     */
    public function editHostAction(Host $host)
    {
        return $this->getFrontendController()->editEntity($host);
    }

    /**
     * @Template("CertUnlpNgenBundle:Host:Frontend/hostDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_host_detail")
     * @param Host $host
     * @return array
     */
    public function detailHostAction(Host $host)
    {
        return $this->getFrontendController()->detailEntity($host);
    }

    /**
     * @Template("CertUnlpNgenBundle:Incident:Frontend/incidentComments.html.twig")
     * @param Host $incident
     * @param Request $request
     * @return array
     */
    public function commentsAction(Host $incident, Request $request)
    {
        return $this->getFrontendController()->commentsEntity($incident, $request);
    }

}
