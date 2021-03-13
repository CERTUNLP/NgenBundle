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
use CertUnlp\NgenBundle\Form\Incident\IncidentSearchType;
use CertUnlp\NgenBundle\Form\Playbook\PlaybookType;


use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CertUnlp\NgenBundle\Entity\Playbook\Playbook;

class PlaybookFrontendController extends FrontendController
{

    /**
     * @Template("CertUnlpNgenBundle:Playbook:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_playbook_home")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_playbook
     * @return array
     */
    public function homeAction(Request $request, PaginatedFinderInterface $elastica_finder_playbook): array
    {
        return $this->homeEntity($request,$elastica_finder_playbook);
//        $search = $this->searchEntity($request, $elastica_finder_playbook);
//        return array('objects' => $search['objects'], 'term' => $search['term'], 'lang' => $search['lang']);

    }

    /**
     * @Template("CertUnlpNgenBundle:Playbook:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_playbook_search")
     * @param Request $request
     * @param PaginatedFinderInterface $elastica_finder_playbook
     * @return array
     */
    public function searchPlaybookAction(Request $request, PaginatedFinderInterface $elastica_finder_playbook): array
    {
        return $this->searchEntity($request, $elastica_finder_playbook);
    }


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

    /**
     * @Template("CertUnlpNgenBundle:Playbook:Frontend/playbookDetail.html.twig")
     * @Route("{id}/detail", name="cert_unlp_ngen_playbook_detail_id",requirements={"id"="\d+"})
     * @Route("{slug}/detail", name="cert_unlp_ngen_playbook_detail_slug")
     * @param Playbook $playbook
     * @return array
     */
    public function detailPlaybookAction(Playbook $playbook): array
    {
        return $this->detailEntity($playbook);
    }
}
