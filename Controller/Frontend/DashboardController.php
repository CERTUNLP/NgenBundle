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
//        $address = $this->getDoctrine()->getRepository(Network::class)->findByAddress(['address' => '163.10.42.242']);
//        $address = new NetworkInternal('2001:4860::/32');
//        $this->getDoctrine()->getManager()->persist($address);
//        $this->getDoctrine()->getManager()->flush();
        return $this->redirect($this->generateUrl('cert_unlp_ngen_internal_incident_frontend_home'));

    }
}
