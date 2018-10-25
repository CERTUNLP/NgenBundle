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

use CertUnlp\NgenBundle\Entity\IncidentReport;
use CertUnlp\NgenBundle\Entity\IncidentType;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentReportController extends FOSRestController
{

    /**
     * Gets a Network for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a network admin for a given id",
     *   output = "CertUnlp\NgenBundle\Entity\IncidentReport",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the network is not found"
     *   }
     * )
     *
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @return IncidentReport
     * @FOS\View(
     *  templateVar="incident_report"
     * )
     * @ParamConverter("lang", class="CertUnlpNgenBundle:IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function getReportAction(IncidentType $slug, IncidentReport $lang)
    {
        return $lang;
    }

    /**
     * Create a Network from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new network from the submitted data.",
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param Request $request the request object
     *
     * @param IncidentType $slug
     * @return FormTypeInterface|View
     */
    public function postReportAction(Request $request, IncidentType $slug)
    {
        return $this->getApiController()->post($request);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.incident.type.report.api.controller');
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @param Request $request the request object
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @return FormTypeInterface|View
     *
     * @ParamConverter("lang", class="CertUnlpNgenBundle:IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function patchReportAction(Request $request, IncidentType $slug, IncidentReport $lang)
    {

        return $this->getApiController()->patch($request, $lang, true);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @return FormTypeInterface|View
     *
     * @ParamConverter("lang", class="CertUnlpNgenBundle:IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function patchReportActivateAction(Request $request, IncidentType $slug, IncidentReport $lang)
    {

        return $this->getApiController()->activate($request, $lang);
    }

    /**
     * Update existing network from the submitted data or create a new network at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "CertUnlp\NgenBundle\Form\NetworkType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @return FormTypeInterface|View
     *
     * @ParamConverter("lang", class="CertUnlpNgenBundle:IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function patchReportDesactivateAction(Request $request, IncidentType $slug, IncidentReport $lang)
    {

        return $this->getApiController()->desactivate($request, $lang);
    }

}
