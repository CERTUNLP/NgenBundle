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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.incident.external.frontend.controller');
    }

    /**
     * @Template()
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function homeAction()
    {

        return $this->redirect($this->generateUrl('cert_unlp_ngen_internal_incident_frontend_home'));

    }
}
