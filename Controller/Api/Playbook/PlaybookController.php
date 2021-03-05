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
 * Description of PlaybookController
 *
 * @author asanchezg
 */
namespace CertUnlp\NgenBundle\Controller\Api\Playbook;

use CertUnlp\NgenBundle\Controller\Api\ApiController;
use CertUnlp\NgenBundle\Entity\Playbook\Playbook;
use CertUnlp\NgenBundle\Form\Playbook\PlaybookType as PlaybookForm;
use CertUnlp\NgenBundle\Service\Api\Handler\Playbook\PlaybookHandler;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaybookController extends ApiController
{
    /**
     * IncidentPlaybookController constructor.
     * @param PlaybookHandler $handler
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(PlaybookHandler $handler, ViewHandlerInterface $viewHandler)
    {
        parent::__construct($handler, $viewHandler);
    }

    /**
     * @Operation(
     *     tags={"playbooks"},
     *     summary="Gets a playbook for a given id",
     *      @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *         @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=Playbook::class, groups={"api"}))
     *          )
     *      ),
     *      @SWG\Response(
     *         response="404",
     *         description="Returned when the playbook is not found",
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
     * @param Playbook $playbook
     * @return View
     * @FOS\Get("/playbooks/{id}", name="_id",requirements={"id"="\d+"}))
     */
    public function getPlaybookAction(Playbook $playbook): View
    {
        return $this->response([$playbook], Response::HTTP_OK);
    }

        /**
     * @Operation(
     *     tags={"playbooks"},
     *     summary="Creates a new playbook from the submitted data.",
     *     @SWG\Parameter(
     *         name="form",
     *         in="body",
     *         description="creation parameters",
     *         @Model(type=PlaybookForm::class, groups={"api"})
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Returned when successful",
     *         @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=Playbook::class, groups={"api"}))
     *          )
     *     ),
     *     @SWG\Response(
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
     *  )
     * @FOS\Post("/playbooks")
     * @param Request $request the request object
     * @return View
     */
    public function postPlaybookAction(Request $request): View
    {
        return $this->post($request);
    }
}