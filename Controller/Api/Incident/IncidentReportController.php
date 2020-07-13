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
use CertUnlp\NgenBundle\Exception\InvalidFormException;
use CertUnlp\NgenBundle\Form\Incident\IncidentReportType;
use CertUnlp\NgenBundle\Service\Api\Handler\Incident\IncidentReportHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IncidentReportController extends ApiController
{
    /**
     * IncidentReportController constructor.
     * @param IncidentReportHandler $handler
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(IncidentReportHandler $handler, ViewHandlerInterface $viewHandler)
    {
        parent::__construct($handler, $viewHandler);
    }

    /**
     * @Operation(
     *     tags={"Incident reports"},
     *     summary="List all incident reports.",
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset from which to start listing",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="How many entities to return",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentReport::class, groups={"api"}))
     *          )
     *     ),
     * )
     * @FOS\Get("/incident/types/reports")
     * @FOS\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing incident priorities.")
     * @FOS\QueryParam(name="limit", requirements="\d+", strict=true, default="100", description="How many incident priorities to return.")
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     * @return View
     */
    public function getIncidentPrioritiesAction(ParamFetcherInterface $paramFetcher): View
    {
        return $this->getAll($paramFetcher);
    }


    /**
     * @Operation(
     *     tags={"Incident reports"},
     *     summary="Removes a report",
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentReport::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Delete("/incidents/types/{type}/reports/{lang}", name="_id", requirements={"id"="\d+"}))
     * @FOS\Delete("/incidents/types/reports/{slug}", name="_slug")
     * @param IncidentReport $incident_report
     * @return View
     */
    public function deleteIncidentReportAction(IncidentReport $incident_report): View
    {
        return $this->delete($incident_report);
    }

    /**
     * @Operation(
     *     tags={"Incident reports"},
     *     summary="Gets a network admin for a given id",
     *     @SWG\Parameter(
     *         name="lang",
     *         in="path",
     *         type="string",
     *         enum={"es", "en"},
     *         required=true,
     *         description="Report language"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentReport::class, groups={"api"}))
     *          )
     *     ),
     *      @SWG\Response(
     *         response="404",
     *         description="Returned when the incident is not found",
     *          @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *     )
     * )
     * @FOS\Get("/incidents/types/{type}/reports/{lang}")
     * @FOS\Get("/incidents/types/reports/{slug}", name="_slug")
     * @ParamConverter("incident_report", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     * @param IncidentReport $incident_report
     * @return View
     */
    public function getReportAction(IncidentReport $incident_report): View
    {
        try {
            return $this->response([$incident_report], Response::HTTP_OK);
        } catch (InvalidFormException $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * @Operation(
     *     tags={"Incident reports"},
     *     summary="Creates a new report from the submitted data.",
     *     @SWG\Parameter(
     *         name="lang",
     *         in="path",
     *         type="string",
     *         enum={"es", "en"},
     *         required=true,
     *         description="Report language"
     *     ),
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentReportType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentReport::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @param Request $request the request object
     * @return View
     */
    public function postReportAction(Request $request): View
    {
        return $this->post($request);
    }

    /**
     * @Operation(
     *     tags={"Incident reports"},
     *     summary="Update existing report from the submitted data",
     *     @SWG\Parameter(
     *         name="lang",
     *         in="path",
     *         type="string",
     *         enum={"es", "en"},
     *         required=true,
     *         description="Report language"
     *     ),
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=IncidentReportType::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentReport::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Patch("/incidents/types/{type}/reports/{lang}")
     * @FOS\Patch("/incidents/types/reports/{slug}", name="_slug")
     * @ParamConverter("incident_report", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     * @param Request $request the request object
     * @param IncidentReport $incident_report
     * @return View
     */
    public function patchReportAction(Request $request, IncidentReport $incident_report): View
    {
        return $this->patch($request, $incident_report, true);
    }

    /**
     * @Operation(
     *     tags={"Incident reports"},
     *     summary="Activates an existing report",
     *     @SWG\Parameter(
     *         name="lang",
     *         in="path",
     *         type="string",
     *         enum={"es", "en"},
     *         required=true,
     *         description="Report language"
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentReport::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Patch("/incidents/types/{type}/reports/{lang}/activate")
     * @FOS\Patch("/incidents/types/reports/{slug}/activate", name="_slug")
     * @ParamConverter("incident_report", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     * @param IncidentReport $incident_report
     * @return View
     */
    public function patchReportActivateAction(IncidentReport $incident_report): View
    {
        return $this->activate($incident_report);
    }

    /**
     * @Operation(
     *     tags={"Incident reports"},
     *     summary="Desactivates an existing report",
     *     @SWG\Parameter(
     *         name="lang",
     *         in="path",
     *         type="string",
     *         enum={"es", "en"},
     *         required=true,
     *         description="Report language"
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=IncidentReport::class, groups={"api"}))
     *          )
     *     ),
     *    @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors",
     *         @SWG\schema(
     *              type="array",
     *              @SWG\items(
     *                  type="object",
     *                  @SWG\Property(property="code", type="string"),
     *                  @SWG\Property(property="message", type="string"),
     *                  @SWG\Property(property="errors", type="array",
     *                      @SWG\items(
     *                          type="object",
     *                          @SWG\Property(property="global", type="string"),
     *                          @SWG\Property(property="fields", type="string"),
     *                      )
     *                  ),
     *              )
     *          )
     *      )
     * )
     * @FOS\Patch("/incidents/types/{type}/reports/{lang}/desactivate")
     * @FOS\Patch("/incidents/types/reports/{slug}/desactivate", name="_slug")
     * @ParamConverter("incident_report", class="CertUnlp\NgenBundle\Entity\Incident\IncidentReport", options={"mapping": {"lang": "lang", "slug": "type"}})
     * @param IncidentReport $incident_report
     * @return View
     */
    public function patchReportDesactivateAction(IncidentReport $incident_report): View
    {
        return $this->desactivate($incident_report);
    }

}
