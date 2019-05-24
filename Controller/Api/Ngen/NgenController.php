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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Entity\Incident\IncidentState;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class NgenController extends FOSRestController
{

    /**
     * Get status.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     401 = "Returned when the apikey is not found"
     *   }
     * )
     *
     * @param Request $request
     * @return array
     * @FOS\Get("/ngen/status")
     */
    public function getNgenAction(Request $request)
    {
        return null;
    }

    /**
     * Get version.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     401 = "Returned when the apikey is not found"
     *   }
     * )
     *
     * @param Request $request
     * @return array
     * @FOS\Get("/ngen/version")
     */
    public function getVersionAction(Request $request)
    {
        return "0.0.2";
    }

}
