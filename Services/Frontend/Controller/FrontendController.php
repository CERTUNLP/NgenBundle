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
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class FrontendController
{

    protected $entityType;
    protected $formFactory;
    private $doctrine;
    private $paginator;
    private $finder;
    private $comment_manager;
    private $thread_manager;

    public function __construct($doctrine, FormFactory $formFactory, $entityType, Paginator $paginator, PaginatedFinderInterface $finder, CommentManagerInterface $comment_manager, ThreadManagerInterface $thread_manager)
    {
        $this->doctrine = $doctrine;
        $this->paginator = $paginator;
        $this->finder = $finder;
        $this->entityType = $entityType;
        $this->formFactory = $formFactory;
        $this->comment_manager = $comment_manager;
        $this->thread_manager = $thread_manager;
    }

    public function getDoctrine()
    {
        return $this->doctrine;
    }

    public function homeEntity(Request $request, $term = '', $limit = 7, $defaultSortFieldName='createdAt',$defaultSortDirection='desc')
    {
        return $this->searchEntity($request, $term, $limit,$defaultSortFieldName,$defaultSortDirection);
    }

    public function searchEntity(Request $request, $term = null, $limit = 7, $defaultSortFieldName='createdAt',$defaultSortDirection='desc')
    {
        if (!$term) {
            $term = $request->get('term') ? $request->get('term') : '*';
        }
        $results = $this->getFinder()->createPaginatorAdapter($term);

        $pagination = $this->getPaginator()->paginate(
            $results, $request->query->get('page', 1), $limit
            , array('defaultSortFieldName' => $defaultSortFieldName, 'defaultSortDirection' => $defaultSortDirection)
        );

        $pagination->setParam('term', $term);

        return array('objects' => $pagination, 'term' => $term);
    }

    /**
     * @return PaginatedFinderInterface
     */
    public function getFinder()
    {
        return $this->finder;
    }

    public function getPaginator()
    {
        return $this->paginator;
    }

    public function newEntity(Request $request)
    {
        return array('form' => $this->formFactory->create(new $this->entityType($this->doctrine))->createView(), 'method' => 'POST');
    }

    public function editEntity($object)
    {
        return array('form' => $this->formFactory->create(new $this->entityType($this->doctrine), $object)->createView(), 'method' => 'patch');
    }

    public function detailEntity($object)
    {
        return array('object' => $object);
    }

    /**
     * @param Incident $object
     * @param Request $request
     * @return array
     */
    public function commentsEntity($object, Request $request)
    {
        $id = $object->getId();
        $thread = $this->thread_manager->findThreadById($id);
        if (null === $thread) {
            $thread = $this->thread_manager->createThread();
            $thread->setId($id);
            $object->setCommentThread($thread);
//            $thread->setIncident($object);
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->thread_manager->saveThread($thread);
        }

        $comments = $this->comment_manager->findCommentTreeByThread($thread);

        return array(
            'comments' => $comments,
            'thread' => $thread,
        );
    }

}
