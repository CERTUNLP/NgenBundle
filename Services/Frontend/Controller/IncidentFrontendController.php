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
use CertUnlp\NgenBundle\Form\IncidentType;
use Doctrine\Persistence\ManagerRegistry;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ZipArchive;

class IncidentFrontendController extends FrontendController
{

    private $evidence_path;
    private $userLogged;

    public function __construct(ManagerRegistry $doctrine, FormFactoryInterface $formFactory, IncidentType $entity_type, PaginatorInterface $paginator, PaginatedFinderInterface  $elastica_finder_incident, CommentManagerInterface $comment_manager, ThreadManagerInterface $thread_manager, TokenStorageInterface $securityContext, string $evidence_path)
    {
        parent::__construct($doctrine, $formFactory, $entity_type, $paginator, $elastica_finder_incident, $comment_manager, $thread_manager);
        $this->evidence_path = $evidence_path;
        $this->userLogged = $securityContext->getToken()->getUser();
    }

    /**
     * @return string|UserInterface
     */
    public function getUserLogged()
    {
        return $this->userLogged;
    }

    /**
     * @param string|UserInterface $userLogged
     */
    public function setUserLogged($userLogged): void
    {
        $this->userLogged = $userLogged;
    }

    public function evidenceIncidentAction(Incident $incident)
    {

        // Create new Zip Archive.
        $zip = new ZipArchive();

        // The name of the Zip documents.
        $evidence_path = $this->getEvidencePath() . $incident->getEvidenceSubDirectory() . "/";
        $zipName = $evidence_path . 'EvidenceDocuments' . $incident->getSlug() . '.zip';
//        $options = array('remove_all_path' => TRUE);
        $zip->open($zipName, ZipArchive::CREATE);
        foreach ($incident->getIncidentsDetected() as $detected) {
            if ($detected->getEvidenceFilePath()) {
                $zip->addFile($this->getEvidencePath() . $detected->getEvidenceFilePath(), $detected->getEvidenceFilePath());
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

    /**
     * @return string
     */
    public function getEvidencePath(): string
    {
        return $this->evidence_path;
    }

    /**
     * @param string $evidence_path
     */
    public function setEvidencePath(string $evidence_path): void
    {
        $this->evidence_path = $evidence_path;
    }

    public function homeEntity(Request $request, $term = '', $limit = 7, $defaultSortFieldName = 'createdAt', $defaultSortDirection = 'desc')
    {
        if (!$term) {
            $term = $request->get('term') ?: '*';
        }
        $quickSearchForm = $this->getFormFactory()->createBuilder(IncidentSearchType::class, (new Incident), array('csrf_protection' => true));
        return array('objects' => $this->searchEntity($request, $term, $limit, $defaultSortFieldName, $defaultSortDirection, 'pageobject', 'object')['objects'], 'search_form' => $quickSearchForm->getForm()->createView());

    }

}
