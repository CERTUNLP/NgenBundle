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

use CertUnlp\NgenBundle\Entity\Incident\Incident;
use CertUnlp\NgenBundle\Form\IncidentSearchType;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IncidentFrontendController extends FrontendController
{

    private $evidence_path;
    private $userLogged;

    public function __construct($doctrine, FormFactory $formFactory, $entityType, Paginator $paginator, PaginatedFinderInterface $finder, CommentManagerInterface $comment_manager, ThreadManagerInterface $thread_manager, $securityContext, string $evidence_path)
    {
        parent::__construct($doctrine, $formFactory, $entityType, $paginator, $finder, $comment_manager, $thread_manager);
        $this->evidence_path = $evidence_path;
        $this->userLogged = $securityContext->getToken()->getUser();
    }

    public function evidenceIncidentAction(Incident $incident)
    {

        // Create new Zip Archive.
        $zip = new \ZipArchive();

        // The name of the Zip documents.
        $evidence_path = $this->evidence_path . $incident->getEvidenceSubDirectory() . "/";
        $zipName = $evidence_path . 'EvidenceDocuments' . $incident . '.zip';
        $options = array('remove_all_path' => TRUE);
        $zip->open($zipName, \ZipArchive::CREATE);
        foreach ($incident->getIncidentsDetected() as $detected) {
            if ($detected->getEvidenceFilePath()) {
                $zip->addFile($this->evidence_path . $detected->getEvidenceFilePath(), $detected->getEvidenceFilePath());
            }
        }
        //$zip->addGlob($evidence_path . "*", GLOB_BRACE, $options);
        $zip->close();
        $response = new Response(file_get_contents($zipName));
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $zipName . '"');
        $response->headers->set('Content-length', filesize($zipName));

        @unlink($zipName);

        return $response;


    }

    public function newEntity(Request $request)
    {
        return array('form' => $this->formFactory->create(new $this->entityType($this->getDoctrine(), $this->userLogged->getId()))->createView(), 'method' => 'POST');
    }

    public function editEntity($object)
    {
        return array('form' => $this->formFactory->create(new $this->entityType($this->getDoctrine(), $this->userLogged->getId()), $object)->createView(), 'method' => 'patch');
    }

    public function homeEntity(Request $request, $term = '', $limit = 7, $defaultSortFieldName = 'createdAt', $defaultSortDirection = 'desc')
    {
        if (!$term) {
            $term = $request->get('term') ?: '*';
        }
        $quickSearchForm = $this->formFactory->createBuilder(IncidentSearchType::class, (new Incident), array('csrf_protection' => true));
        return array('objects' => $this->searchEntity($request, $term, $limit, $defaultSortFieldName, $defaultSortDirection, 'pageobject', 'object')['objects'], 'search_form' => $quickSearchForm->getForm()->createView());

    }

}
