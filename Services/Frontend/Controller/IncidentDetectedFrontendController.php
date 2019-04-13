<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Services\Frontend\Controller;

use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Response;
use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;


class IncidentDetectedFrontendController extends FrontendController
{
    private $evidence_path;
    private $userLogged;

    public function __construct($doctrine, FormFactory $formFactory, $entityType, Paginator $paginator, PaginatedFinderInterface $finder, CommentManagerInterface $comment_manager, ThreadManagerInterface $thread_manager, $securityContext, string $evidence_path)
    {
        parent::__construct($doctrine, $formFactory, $entityType, $paginator, $finder, $comment_manager, $thread_manager);
        $this->evidence_path = $evidence_path;
        $this->userLogged = $securityContext->getToken()->getUser();
    }

    public function evidenceIncidentAction(IncidentDetected $incident)
    {

        $evidence_file = $this->evidence_path . $incident->getIncident()->getEvidenceSubDirectory() . "/" . $incident->getEvidenceFilePath();

        $response = new Response(file_get_contents($evidence_file));
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $evidence_file . '"');
        $response->headers->set('Content-length', filesize($evidence_file));

        @unlink($evidence_file);

        return $response;


    }

}
