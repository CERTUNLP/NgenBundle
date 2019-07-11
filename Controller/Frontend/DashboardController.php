<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DashboardController extends Controller
{


    /**
     * @Template("CertUnlpNgenBundle:Dashboard:frontend.html.twig")
     * @Route("/")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return array("externalDashboard"=>$this->container->getParameter('cert_unlp.ngen.grafana.external.url'),"internalDashboard"=>$this->container->getParameter('cert_unlp.ngen.grafana.internal.url'));
    }

}
