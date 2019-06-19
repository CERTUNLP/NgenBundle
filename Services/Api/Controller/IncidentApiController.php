<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Api\Controller;

use Symfony\Component\HttpFoundation\Response;

class IncidentApiController extends ApiController
{
    /**
     * Prints a mail template for the given incident.
     *
     * @param $slug
     * @return Response
     */
            public function reportHtmlAction($slug)
    {
        $data = array('state' => $slug);
        $this->getView()->setTemplate('CertUnlpNgenBundle:Incident:Report/Twig/incidentReportHtml.html.twig');
        $this->getView()->setTemplateData($data);
        return $this->handle();
    }

}
