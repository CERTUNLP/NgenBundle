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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractController
{

    /**
     * @Template("CertUnlpNgenBundle:Dashboard:frontend.html.twig")
     * @Route("/internal",name="cert_unlp_ngen_dashboard_internal")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request): array
    {
        return array("dashboard" => $this->container->getParameter('cert_unlp.ngen.grafana.internal.url'));
    }

    /**
     * @Template("CertUnlpNgenBundle:Dashboard:frontend.html.twig")
     * @Route("/external",name="cert_unlp_ngen_dashboard_external")
     * @param Request $request
     * @return array
     */
    public function externalAction(Request $request): array
    {
        return array("dashboard" => $this->container->getParameter('cert_unlp.ngen.grafana.external.url'));
    }

}
