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
     * @var string
     */
    private $grafana_internal_url;
    /**
     * @var string
     */
    private $grafana_external_url;

    /**
     * DashboardController constructor.
     * @param string $grafana_internal_url
     * @param string $grafana_external_url
     */
    public function __construct(string $grafana_internal_url, string $grafana_external_url)
    {
        $this->grafana_internal_url = $grafana_internal_url;
        $this->grafana_external_url = $grafana_external_url;
    }

    /**
     * @Template("CertUnlpNgenBundle:Dashboard:frontend.html.twig")
     * @Route("/internal",name="cert_unlp_ngen_dashboard_internal")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request): array
    {
        return array("dashboard" => $this->getGrafanaInternalUrl());
    }

    /**
     * @return string
     */
    public function getGrafanaInternalUrl(): string
    {
        return $this->grafana_internal_url;
    }

    /**
     * @Template("CertUnlpNgenBundle:Dashboard:frontend.html.twig")
     * @Route("/external",name="cert_unlp_ngen_dashboard_external")
     * @param Request $request
     * @return array
     */
    public function externalAction(Request $request): array
    {
        return array("dashboard" => $this->getGrafanaExternalUrl());
    }

    /**
     * @return string
     */
    public function getGrafanaExternalUrl(): string
    {
        return $this->grafana_external_url;
    }

}
