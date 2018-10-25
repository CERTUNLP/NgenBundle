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

use CertUnlp\NgenBundle\Entity\AcademicUnit;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class AcademicUnitController extends FOSRestController
{

    /**
     * List all networks.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getAction(Request $request, ParamFetcherInterface $paramFetcher)
    {

        return null;
    }

    /**
     * List all academic unit academic_unit.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @FOS\Get("/academic_unit")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing academic unit academic_unit.")
     * @FOS\QueryParam(name="limit", requirements="\d+", default="5", description="How many academic unit academic_unit to return.")
     *
     * @FOS\View(
     *  templateVar="academic_units"
     * )
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getAcademicUnitsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return $this->getApiController()->getAll($request, $paramFetcher);
    }

    public function getApiController()
    {

        return $this->container->get('cert_unlp.ngen.academic_unit.api.controller');
    }

    /**
     * Gets a Network for a given id.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a network admin for a given id",
     *   output = "CertUnlp\NgenBundle\Entity\AcademicUnit",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the network is not found"
     *   }
     * )
     *
     * @param AcademicUnit $academic_unit
     * @return AcademicUnit
     * @FOS\View(
     *  templateVar="academic_unit"
     * )
     * @ParamConverter("academic_unit", class="CertUnlpNgenBundle:AcademicUnit")
     * @FOS\Get("/academic_unit/{slug}")
     */
    public function getAcademicUnitAction(AcademicUnit $academic_unit)
    {
        return $academic_unit;
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
     * @FOS\Post("/academic_unit")
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postAcademicUnitAction(Request $request)
    {
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
     * @FOS\Patch("/academic_unit/{slug}")
     * @param Request $request the request object
     * @param AcademicUnit $academic_unit
     * @return FormTypeInterface|View
     *
     */
    public function patchAcademicUnitAction(Request $request, AcademicUnit $academic_unit)
    {
        return $this->getApiController()->patch($request, $academic_unit, true);
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
     * @FOS\Patch("/academic_unit/{slug}")
     * @param Request $request the request object
     * @param AcademicUnit $academic_unit
     * @return FormTypeInterface|View
     *
     */
    public function patchAcademicUnitBySlugAction(Request $request, AcademicUnit $academic_unit)
    {
        return $this->getApiController()->patch($request, $academic_unit);
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
     * @param AcademicUnit $academic_unit
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/academic_unit/{slug}/activate")
     */
    public function patchAcademicUnitActivateAction(Request $request, AcademicUnit $academic_unit)
    {

        return $this->getApiController()->activate($request, $academic_unit);
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
     * @param AcademicUnit $academic_unit
     * @return FormTypeInterface|View
     *
     * @FOS\Patch("/academic_unit/{slug}/desactivate")
     */
    public function patchAcademicUnitDesactivateAction(Request $request, AcademicUnit $academic_unit)
    {

        return $this->getApiController()->desactivate($request, $academic_unit);
    }

}
