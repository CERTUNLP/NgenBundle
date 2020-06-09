<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Api\Incident;

use CertUnlp\NgenBundle\Controller\Api\ApiController;
use CertUnlp\NgenBundle\Entity\Incident\IncidentReport;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Service\Api\Handler\IncidentReportHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentReportController extends ApiController
{
    /**
     * IncidentReportController constructor.
     * @param IncidentReportHandler $handler
     * @param ViewHandlerInterface $viewHandler
     * @param View $view
     */
    public function __construct(IncidentReportHandler $handler, ViewHandlerInterface $viewHandler, View $view)
    {
        parent::__construct($handler, $viewHandler, $view);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Gets a network admin for a given id",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the network is not found"
     *     )
     * )
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @return IncidentReport
     * @FOS\View(
     *  templateVar="incident_report"
     * )
     * @ParamConverter("lang", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function getReportAction(IncidentType $slug, IncidentReport $lang)
    {
        return $lang;
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Creates a new network from the submitted data.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="formData",
     *         description="",
     *         required=false,
     *         type="object (NetworkType)"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @param Request $request the request object
     * @param IncidentType $slug
     * @return FormTypeInterface|View
     */
    public function postReportAction(Request $request, IncidentType $slug)
    {
        return $this->post($request);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @param Request $request the request object
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @return FormTypeInterface|View
     * @ParamConverter("lang", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function patchReportAction(Request $request, IncidentType $slug, IncidentReport $lang)
    {
        return $this->patch($request, $lang, true);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @param Request $request the request object
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @return FormTypeInterface|View
     * @ParamConverter("lang", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function patchReportActivateAction(Request $request, IncidentType $slug, IncidentReport $lang)
    {
        return $this->activate($request, $lang);
    }

    /**
     * @Operation(
     *     tags={""},
     *     summary="Update existing network from the submitted data or create a new network at a specific location.",
     *     @SWG\Parameter(
     *         name="network",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(type="object (NetworkType)")
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     * @param Request $request the request object
     * @param IncidentType $slug
     * @param IncidentReport $lang
     * @return FormTypeInterface|View
     * @ParamConverter("lang", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     */
    public function patchReportDesactivateAction(Request $request, IncidentType $slug, IncidentReport $lang)
    {
        return $this->desactivate($request, $lang);
    }

}
