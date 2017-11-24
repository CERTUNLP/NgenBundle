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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use CertUnlp\NgenBundle\Form\IncidentReportType;
use CertUnlp\NgenBundle\Entity\IncidentReport;
use CertUnlp\NgenBundle\Entity\IncidentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as FOS;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use CertUnlp\NgenBundle\Exception\InvalidFormException;

class IncidentReportController extends FOSRestController {

    public function getApiController() {

        return $this->container->get('cert_unlp.ngen.incident.type.report.api.controller');
    }

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
     * @param int     $id      the network id
     *
     * @return array
     * @FOS\View(
     *  templateVar="incident_report"
     * )
     * @throws NotFoundHttpException when network not exist
     * @ParamConverter("lang", class="CertUnlpNgenBundle:IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function getReportAction(IncidentType $slug, IncidentReport $lang) {
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
     * @return FormTypeInterface|View

     */
    public function postReportAction(Request $request, IncidentType $slug) {
        return $this->getApiController()->post($request);
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
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     * @ParamConverter("lang", class="CertUnlpNgenBundle:IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function patchReportAction(Request $request, IncidentType $slug, IncidentReport $lang) {

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
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     * @ParamConverter("lang", class="CertUnlpNgenBundle:IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function patchReportActivateAction(Request $request, IncidentType $slug, IncidentReport $lang) {

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
     * @param int     $id      the network id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when network not exist
     * @ParamConverter("lang", class="CertUnlpNgenBundle:IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function patchReportDesactivateAction(Request $request, IncidentType $slug, IncidentReport $lang) {

        return $this->getApiController()->desactivate($request, $lang);
    }

}
