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
 * Description of IncidentStateFrontendController
 *
 * @author dam
 */

namespace CertUnlp\NgenBundle\Controller\Frontend\Incident;

use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;
use CertUnlp\NgenBundle\Service\Frontend\Controller\IncidentDetectedFrontendControllerService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IncidentDetectedFrontendController extends Controller
{

    /**
     * @Route("{id}/evidence_detected", name="cert_unlp_ngen_incident_frontend_evidence_incident_detected_id", requirements={"id"="\d+"})
     * @Route("{slug}/evidence_detected", name="cert_unlp_ngen_incident_detected_frontend_evidence_incident_detected_slug")
     * @param IncidentDetected $incident
     * @param IncidentDetectedFrontendControllerService $controller_service
     * @return Response
     */
    public function evidenceIncidentDetectedAction(IncidentDetected $incident, IncidentDetectedFrontendControllerService $controller_service): Response
    {
        return $controller_service->evidenceIncidentAction($incident);
    }

}
