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
 * Description of IncidentTypeFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IncidentTypeFrontendController extends Controller
{

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/home.html.twig")
     * @Route("/", name="cert_unlp_ngen_administration_type_frontend_home")
     * @param Request $request
     * @return array
     */
    public function homeAction(Request $request)
    {
        return $this->getFrontendController()->homeEntity($request);
    }

    public function getFrontendController()
    {
        return $this->get('cert_unlp.ngen.incident.type.frontend.controller');
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/home.html.twig")
     * @Route("search", name="cert_unlp_ngen_incident_type_search")
     * @param Request $request
     * @return array
     */
    public function searchIncidentTypeAction(Request $request)
    {
        return $this->getFrontendController()->searchEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeForm.html.twig")
     * @Route("/new", name="cert_unlp_ngen_incident_type_new")
     * @param Request $request
     * @return array
     */
    public function newIncidentTypeAction(Request $request)
    {
        return $this->getFrontendController()->newEntity($request);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeForm.html.twig")
     * @Route("{slug}/edit", name="cert_unlp_ngen_incident_type_edit")
     * @param IncidentType $incidentType
     * @return array
     */
    public function editIncidentTypeAction(IncidentType $incidentType)
    {
//        $incidentType->setReportEdit($this->readReportFile($incidentType));

        return $this->getFrontendController()->editEntity($incidentType);
    }

    /**
     * @Template("CertUnlpNgenBundle:IncidentType:Frontend/incidentTypeDetail.html.twig")
     * @Route("{slug}/detail", name="cert_unlp_ngen_incident_type_detail")
     * @param IncidentType $incidentType
     * @return array
     */
    public function detailIncidentTypeAction(IncidentType $incidentType)
    {
        return $this->getFrontendController()->detailEntity($incidentType);
    }

    private function readReportFile(IncidentType $incidentType)
    {
        return $this->container->get('markdown.parser')->transformMarkdown(file_get_contents($this->getReportName($incidentType)));
    }

    private function getReportName(IncidentType $incidentType)
    {
        return $this->getParameter('cert_unlp.ngen.incident.internal.report.markdown.path') . "/" . $incidentType->getReportName();
    }

}
