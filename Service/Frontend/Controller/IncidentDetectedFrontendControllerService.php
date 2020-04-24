<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Frontend\Controller;

use CertUnlp\NgenBundle\Entity\Incident\IncidentDetected;
use CertUnlp\NgenBundle\Form\IncidentType;
use Doctrine\Persistence\ManagerRegistry;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;


class IncidentDetectedFrontendControllerService extends FrontendControllerService
{
    /**
     * @var string
     */
    private $evidence_path;

    /**
     * IncidentDetectedFrontendControllerService constructor.
     * @param ManagerRegistry $doctrine
     * @param FormFactoryInterface $formFactory
     * @param IncidentType $entity_type
     * @param PaginatorInterface $paginator
     * @param PaginatedFinderInterface $elastica_finder_incident
     * @param string $evidence_path
     */
    public function __construct(ManagerRegistry $doctrine, FormFactoryInterface $formFactory, IncidentType $entity_type, PaginatorInterface $paginator, PaginatedFinderInterface $elastica_finder_incident, string $evidence_path)
    {
        parent::__construct($doctrine, $formFactory, $entity_type, $paginator, $elastica_finder_incident);
        $this->evidence_path = $evidence_path;
    }

    /**
     * @param IncidentDetected $incident
     * @return Response
     */
    public function evidenceIncidentAction(IncidentDetected $incident): Response
    {
        $evidence_file = $this->evidence_path . '/' . $incident->getEvidenceFilePath();

        $response = new Response(file_get_contents($evidence_file));
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $evidence_file . '"');
        $response->headers->set('Content-length', filesize($evidence_file));

        return $response;
    }

}
