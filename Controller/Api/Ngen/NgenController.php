<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Api\Ngen;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as FOS;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;

class NgenController extends AbstractFOSRestController
{

    /**
     * @Operation(
     *     tags={"root"},
     *     summary="Get status.",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the apikey is not found"
     *     )
     * )
     * @param Request $request
     * @return array
     * @FOS\Get("/status")
     */
    public function getNgenAction(Request $request): ?array
    {
        return null;
    }

    /**
     * @Operation(
     *     tags={"root"},
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the apikey is not found"
     *     )
     * )
     * @param Request $request
     * @return array
     * @FOS\Get("/")
     */
    public function getAction(Request $request): ?array
    {
        return null;
    }

    /**
     * @Operation(
     *     tags={"root"},
     *     summary="Get version",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the apikey is not found"
     *     )
     * )
     * @param Request $request
     * @return string
     * @FOS\Get("/version")
     */
    public function getVersionAction(Request $request): string
    {
        return '0.0.2';
    }

}
