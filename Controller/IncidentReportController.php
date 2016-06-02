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
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use CertUnlp\NgenBundle\Entity\IncidentType;
use CertUnlp\NgenBundle\Entity\Incident;

class IncidentReportController extends FOSRestController {

    /**
     * Prints a mail template for the given incident.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Prints a mail html template for the given incident.",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the incident is not found"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @param int     $id      the incident id
     *
     * @return array
     */
    public function getIncidentReportMailAction(Incident $incident) {

        return new Response($this->get('cert_unlp.ngen.incident.mailer')->send_report($incident, null, true), Codes::HTTP_OK);
    }

    /**
     * Prints a mail template for the given incident.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Prints a mail twig template for the given incident type.",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the incident is not found"
     *   }
     * )
     *
     * @Annotations\View("CertUnlpNgenBundle:IncidentReport:incidentReportHtml.html.twig")
     *
     * @param int     $id      the incident id
     *
     * @return array
     */
    public function getIncidentReportHtmlAction(IncidentType $incidentType) {

        return array('state' => $incidentType->getSlug());
    }

}
