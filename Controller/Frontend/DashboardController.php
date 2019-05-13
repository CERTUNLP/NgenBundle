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

use CertUnlp\NgenBundle\Entity\Incident\IncidentState;
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
//        $article = $this->get('doctrine')->getManager()->find(IncidentState::class, 'open' /*article id*/);
//        $repository = $this->get('doctrine')->getManager()->getRepository(Translation::class);
//        $translations = $repository->findTranslations($article);
//        var_dump($translations);
//        die;


        $article = new IncidentState();
        $article->setName('asdasda');

        $this->get('doctrine')->getManager()->persist($article);
        $this->get('doctrine')->getManager()->flush();
        die;

    }
}
