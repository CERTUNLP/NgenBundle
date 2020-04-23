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
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Timeline;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use FOS\CommentBundle\Model\CommentManagerInterface;
use FOS\CommentBundle\Model\ThreadManagerInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FrontendController
{

    private $entity_type;
    private $formFactory;
    private $doctrine;
    private $paginator;
    private $finder;
    private $comment_manager;
    private $thread_manager;

    public function __construct(ManagerRegistry $doctrine, FormFactoryInterface $formFactory, $entity_type, PaginatorInterface $paginator, PaginatedFinderInterface $finder, CommentManagerInterface $comment_manager, ThreadManagerInterface $thread_manager)
    {
        $this->doctrine = $doctrine;
        $this->paginator = $paginator;
        $this->finder = $finder;
        $this->entity_type = $entity_type;
        $this->formFactory = $formFactory;
        $this->comment_manager = $comment_manager;
        $this->thread_manager = $thread_manager;
    }

    /**
     * @param array $states
     * @param int $height
     * @return PieChart
     */
    public function makePieChart(array $states, int $height = 150): PieChart
    {
        $pieChart = new PieChart();
        array_unshift($states, ['Task', 'Hours per Day']);
        $pieChart->getData()->setArrayToDataTable(
            $states
        );
        $pieChart->getOptions()->setHeight($height);
        $pieChart->getOptions()->setPieHole(0.5);
        $pieChart->getOptions()->getLegend()->setPosition('none');
        return $pieChart;
    }

    /**
     * @param array $states
     * @return Timeline
     */
    public function makeTimeline(array $states): Timeline
    {
        $timeline = new Timeline();
        $timeline->getOptions()->getTimeline()->setShowBarLabels(false);
        $timeline->getOptions()->getTimeline()->setShowRowLabels(false);
        $timeline->getOptions()->setHeight(91);
        $timeline->getData()->setArrayToDataTable(
            $states, true
        );
        return $timeline;
    }

    /**
     * @param array $ratios
     * @param string $title
     * @return ColumnChart
     */
    public function makeColumnChart(array $ratios, string $title = ''): ColumnChart
    {
        $col = new ColumnChart();

        $sum = 0;
        foreach ($ratios as $ratio) {
            $sum += $ratio[1];
        }

        $title = $title ?: 'Detections';
        array_unshift($ratios, ['Days', $title . ' per Day']);
        $col->getData()->setArrayToDataTable(
            $ratios
        );
        $col->getOptions()->setTitle($title . ': ' . $sum);
        $col->getOptions()->getLegend()->setPosition('none');
        $col->getOptions()->getAnnotations()->setAlwaysOutside(true);
        return $col;
    }

    public function getDoctrine()
    {
        return $this->doctrine;
    }

    public function homeEntity(Request $request, $term = '', $limit = 7, $defaultSortFieldName = 'createdAt', $defaultSortDirection = 'desc')
    {
        return $this->searchEntity($request, $term, $limit, $defaultSortFieldName, $defaultSortDirection);
    }

    public function searchEntity(Request $request, $term = null, $limit = 7, $defaultSortFieldName = 'createdAt', $defaultSortDirection = 'desc', $page = 'page', $field = '')
    {
        if (!$term) {
            $term = $request->get('term') ? $request->get('term') : '*';
        }
        $results = $this->getFinder()->createPaginatorAdapter($term);
        $pagination = $this->getPaginator()->paginate(
            $results, $request->query->get($page, 1), $limit
            , array('pageParameterName' => 'page' . $field, 'sortFieldParameterName' => 'sort' . $field, 'sortDirectionParameterName' => 'direction' . $field, 'defaultSortFieldName' => $defaultSortFieldName, 'defaultSortDirection' => $defaultSortDirection)
        );

        $pagination->setParam('term', $term);
        $pagination->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
        ]);
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

    public function searchAutocompleteEntity(Request $request, $term = null, $limit = 7, $defaultSortFieldName = 'createdAt', $defaultSortDirection = 'desc', $page = 'page', $field = '')
    {
        if (!$term) {
            $term = $request->get('term') ?? $request->get('q') ?? '*';
        }

        $results = $this->getFinder()->find($term . ' && isActive:"true"');

        $array = (new ArrayCollection($results))->map(static function ($element) {
            return ['id' => $element->getId(), 'text' => (string)$element];
        });
        return new JsonResponse($array->toArray());
    }

    public function newEntity(Request $request)
    {
        return array('form' => $this->getFormFactory()->create($this->getEntityType())->createView(), 'method' => 'POST');
    }

    /**
     * @return FormFactoryInterface
     */
    public function getFormFactory(): FormFactoryInterface
    {
        return $this->formFactory;
    }

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory(FormFactoryInterface $formFactory): void
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @return mixed
     */
    public function getEntityType()
    {
        return $this->entity_type;
    }

    /**
     * @param mixed $entity_type
     */
    public function setEntityType($entity_type): void
    {
        $this->entity_type = $entity_type;
    }

    public function editEntity($object)
    {
        return array('form' => $this->getFormFactory()->create($this->getEntityType(), $object)->createView(), 'method' => 'patch');
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

    /**
     * @return CommentManagerInterface
     */
    public function getCommentManager(): CommentManagerInterface
    {
        return $this->comment_manager;
    }

    /**
     * @param CommentManagerInterface $comment_manager
     */
    public function setCommentManager(CommentManagerInterface $comment_manager): void
    {
        $this->comment_manager = $comment_manager;
    }

    /**
     * @return ThreadManagerInterface
     */
    public function getThreadManager(): ThreadManagerInterface
    {
        return $this->thread_manager;
    }

    /**
     * @param ThreadManagerInterface $thread_manager
     */
    public function setThreadManager(ThreadManagerInterface $thread_manager): void
    {
        $this->thread_manager = $thread_manager;
    }

}
