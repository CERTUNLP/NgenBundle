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
 * Description of AcademicUnitFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller;

use CertUnlp\NgenBundle\Entity\AcademicUnit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AcademicUnitFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:AcademicUnit:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_network_network_entity_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.academic_unit.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:AcademicUnit:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_academic_unit_search")
     * @param Request $request
     * @return array
     */
    public function searchAcademicUnitAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:AcademicUnit:Frontend/academicUnitForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_academic_unit_new")
     * @param Request $request
     * @return array
     */
    public function newAcademicUnitAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:AcademicUnit:Frontend/academicUnitForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_academic_unit_edit")
     * @param AcademicUnit $academicUnit
     * @return array
     */
    public function editAcademicUnitAction(AcademicUnit $academicUnit)
    {
        return $this->getFrontendController()->editEntity($academicUnit);
    }

    /**
     * @Template("CertUnlpNgenBundle:AcademicUnit:Frontend/academicUnitDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_academic_unit_detail")
     * @param AcademicUnit $academicUnit
     * @return array
     */
    public function detailAcademicUnitAction(AcademicUnit $academicUnit)
    {
        return $this->getFrontendController()->detailEntity($academicUnit);
    }

}
