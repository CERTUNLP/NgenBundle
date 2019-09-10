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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    /**
     * @param string $type
     * @param string|null $origin
     * @return View
     */
    public function searchByTypeAndAddress(string $type, string $origin = null): View
    {
        $incident = $this->getCustomHandler()->getRepository()->findOneByTypeAndAddress($type, $origin);
        if ($incident) {
            return $this->response([$incident], Response::HTTP_OK);
        }

        throw new NotFoundHttpException(sprintf('%s object not found.', Incident::class));
    }
}
