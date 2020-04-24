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
use ZipArchive;

class IncidentFrontendController extends FrontendController
{

    /**
     * @var string
     */
    private $evidence_path;
//    /**
//     * @var string|UserInterface
//     */
//    private $userLogged;
    /**
     * @var ThreadManagerInterface
     */
    private $thread_manager;
    /**
     * @var CommentManagerInterface
     */
    private $comment_manager;

    /**
     * IncidentFrontendController constructor.
     * @param ManagerRegistry $doctrine
     * @param FormFactoryInterface $formFactory
     * @param IncidentType $entity_type
     * @param PaginatorInterface $paginator
     * @param PaginatedFinderInterface $elastica_finder_incident
     * @param CommentManagerInterface $comment_manager
     * @param ThreadManagerInterface $thread_manager
     * @param string $evidence_path
     */
    public function __construct(ManagerRegistry $doctrine, FormFactoryInterface $formFactory, IncidentType $entity_type, PaginatorInterface $paginator, PaginatedFinderInterface $elastica_finder_incident, CommentManagerInterface $comment_manager, ThreadManagerInterface $thread_manager, string $evidence_path)
    {
        parent::__construct($doctrine, $formFactory, $entity_type, $paginator, $elastica_finder_incident);
        $this->evidence_path = $evidence_path;
//        $this->userLogged = $securityContext->getToken()->getUser();
        $this->comment_manager = $comment_manager;
        $this->thread_manager = $thread_manager;
    }

//    /**
//     * @return string|UserInterface
//     */
//    public function getUserLogged()
//    {
//        return $this->userLogged;
//    }

    /**
     * @param Incident $incident
     * @return Response
     */
    public function evidenceIncidentAction(Incident $incident): Response
    {
        $zip = new ZipArchive();

        // The name of the Zip documents.
        $evidence_path = $this->getEvidencePath() . $incident->getEvidenceSubDirectory() . '/';
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
     * {@inheritDoc}
     */
    public function homeEntity(Request $request, string $term = '', int $limit = 7, string $defaultSortFieldName = 'createdAt', string $defaultSortDirection = 'desc'): array
    {
        if (!$term) {
            $term = $request->get('term') ?: '*';
        }
        $quickSearchForm = $this->getFormFactory()->createBuilder(IncidentSearchType::class, (new Incident), array('csrf_protection' => true));
        return array('objects' => $this->searchEntity($request, $term, $limit, $defaultSortFieldName, $defaultSortDirection, 'pageobject', 'object')['objects'], 'search_form' => $quickSearchForm->getForm()->createView());

    }

    /**
     * @param Incident $object
     * @param Request $request
     * @return array
     */
    public function commentsEntity(Incident $object, Request $request): array
    {
        $id = $object->getId();
        $thread = $this->getThreadManager()->findThreadById($id);
        if (null === $thread) {
            $thread = $this->getThreadManager()->createThread();
            $thread->setId($id);
            $object->setCommentThread($thread);
            $thread->setIncident($object);
            $thread->setPermalink($request->getUri());
            $this->getThreadManager()->saveThread($thread);
        }
        $comments = $this->getCommentManager()->findCommentTreeByThread($thread);
        return array(
            'comments' => $comments,
            'thread' => $thread,
        );
    }

    /**
     * @return ThreadManagerInterface
     */
    public function getThreadManager(): ThreadManagerInterface
    {
        return $this->thread_manager;
    }

    /**
     * @return CommentManagerInterface
     */
    public function getCommentManager(): CommentManagerInterface
    {
        return $this->comment_manager;
    }
}
