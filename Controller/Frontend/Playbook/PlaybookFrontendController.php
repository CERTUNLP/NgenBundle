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
 * Description of PlaybookFrontendController
 *
 * @author asanchezg
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Playbook;

use CertUnlp\NgenBundle\Controller\Frontend\FrontendController;
use CertUnlp\NgenBundle\Form\Playbook\PlaybookType;


use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaybookFrontendController extends FrontendController
{
    
    /**
     * @Template("CertUnlpNgenBundle:Playbook:Frontend/newPlaybookForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_playbook_new")
     * @param PlaybookType $playbook
     * @return array
     */
    public function newPlaybookAction(PlaybookType $playbook): array
    {
        return $this->newEntity($playbook);
    }
}