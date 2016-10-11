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

use Symfony\Component\HttpFoundation\Request;

class FrontendController {

    public function __construct($doctrine, $formFactory, $entityType, $paginator, $finder, $comment_manager, $thread_manager) {
        $this->doctrine = $doctrine;
        $this->paginator = $paginator;
        $this->finder = $finder;
        $this->entityType = $entityType;
        $this->formFactory = $formFactory;
        $this->comment_manager = $comment_manager;
        $this->thread_manager = $thread_manager;
    }

    public function getDoctrine() {
        return $this->doctrine;
    }

    public function getFinder() {
        return $this->finder;
    }

    public function getPaginator() {
        return $this->paginator;
    }

    public function homeEntity(Request $request, $entity) {
        $em = $this->getDoctrine();
        $dql = "SELECT i,s,f,t "
                . "FROM CertUnlpNgenBundle:$entity i join i.state s inner join i.feed f join i.type t "
//                . "WHERE s.slug = 'open' and i.isClosed = false"
        ;
        $query = $em->createQuery($dql);

        $pagination = $this->getPaginator()->paginate(
                $query, $request->query->get('page', 1), 7
                , array('defaultSortFieldName' => 'i.createdAt', 'defaultSortDirection' => 'desc')
        );

        return array('objects' => $pagination);
    }

    public function searchEntity(Request $request) {
//        $results = $finder->createPaginatorAdapter('192.168.1.111');
        $results = $this->getFinder()->find($request->get('term'), 1000);

        $pagination = $this->getPaginator()->paginate(
                $results, $request->query->get('page', 1), 7
                , array('defaultSortFieldName' => 'i.createdAt', 'defaultSortDirection' => 'desc')
        );
        $pagination->setParam('term', $request->get('term'));
        return array('objects' => $pagination, 'term' => $request->get('term'));
    }

    public function newEntity(Request $request) {
        return array('form' => $this->formFactory->create(new $this->entityType())->createView(), 'method' => 'POST');
    }

    public function editEntity($object) {

        return array('form' => $this->formFactory->create(new $this->entityType(), $object)->createView(), 'method' => 'patch');
    }

    public function detailEntity($object) {
        return array('object' => $object);
    }

    public function commentsEntity($object, Request $request) {
        $id = $object->getId();
        $thread = $this->thread_manager->findThreadById($id);
        if (null === $thread) {
            $thread = $this->thread_manager->createThread();
            $thread->setId($id);
            $object->setCommentThread($thread);
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
