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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IncidentDetectedFrontendController extends AbstractController
{
    /**
     * @Route("{id}/evidence_detected", name="cert_unlp_ngen_incident_frontend_evidence_incident_detected_id", requirements={"id"="\d+"})
     * @Route("{slug}/evidence_detected", name="cert_unlp_ngen_incident_detected_frontend_evidence_incident_detected_slug")
     * @param IncidentDetected $detection
     * @param string $evidence_path
     * @return Response
     */
    public function evidenceIncidentDetectedAction(IncidentDetected $detection, string $evidence_path): Response
    {
        $evidence_file = $evidence_path . '/' . $detection->getEvidenceFilePath();

        $response = new Response(file_get_contents($evidence_file));
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $evidence_file . '"');
        $response->headers->set('Content-length', filesize($evidence_file));

        return $response;
    }
}
