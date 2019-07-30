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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
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


        /** @var Incident $article */
        $article = $this->get('doctrine')->getRepository(Incident::class)->findOneBy(['id' => '35'] /*article id*/);
        $closed = $this->get('doctrine')->getRepository(IncidentState::class)->findOneBy(['slug' => 'closed'] /*article id*/);
        $open = $this->get('doctrine')->getRepository(IncidentState::class)->findOneBy(['slug' => 'open'] /*article id*/);
//        $repository = $this->get('doctrine')->getManager()->getRepository(Translation::class);
//        $translations = $repository->findTranslations($article);
        var_dump($article->getState()->getName());
        $article->setState($open);
        $article->setState($closed);
//        var_dump($article->getNewStates()->map(function($state){
//            return $state->getName();
//        }));
        die;


//        $article = new IncidentState();
//        $article->setName('asdasda');
//
//        $this->get('doctrine')->getManager()->persist($article);
//        $this->get('doctrine')->getManager()->flush();
//        die;

    }
}
