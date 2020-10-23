<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Controller\Frontend;

use CertUnlp\NgenBundle\Model\EntityApiInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Timeline;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use FOS\ElasticaBundle\Paginator\PaginatorAdapterInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class FrontendController extends AbstractController
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var FormFactoryInterface
     */
    private $form_factory;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var string
     */
    private $defaultSortFieldName;
    /**
     * @var string
     */
    private $defaultSortDirection;
    /**
     * @var string
     */
    private $page;

    /**
     * FrontendControllerService constructor.
     * @param FormFactoryInterface $formFactory
     * @param PaginatorInterface $paginator
     */
    public function __construct(FormFactoryInterface $formFactory, PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
        $this->form_factory = $formFactory;
        $this->limit = 7;
        $this->defaultSortFieldName = 'createdAt';
        $this->defaultSortDirection = 'desc';
        $this->page = 'page';

    }

    /**
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
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

    /**
     * @param Request $request
     * @param PaginatedFinderInterface $finder
     * @return array
     */
    public function homeEntity(Request $request, PaginatedFinderInterface $finder): array
    {
        return $this->searchEntity($request, $finder);
    }

    /**
     * @param Request $request
     * @param PaginatedFinderInterface $finder
     * @return array
     */
    public function searchEntity(Request $request, PaginatedFinderInterface $finder): array
    {
        $term = $this->parseTerm($request);
        $results = $this->getResults($finder, $this->parseTerm($request));
        $pagination = $this->paginateEntities($results, $request);
        return array('objects' => $pagination, 'term' => $term);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function parseTerm(Request $request): string
    {
        return $request->get('term') ?: '*';
    }

    /**
     * @param PaginatedFinderInterface $finder
     * @param string|null $term
     * @return PaginatorAdapterInterface
     */
    public function getResults(PaginatedFinderInterface $finder, ?string $term): PaginatorAdapterInterface
    {
        return $finder->createPaginatorAdapter($term);
    }

    /**
     * @param PaginatorAdapterInterface | array $results
     * @param Request $request
     * @return PaginationInterface
     */
    public function paginateEntities($results, Request $request): PaginationInterface
    {
        $pagination = $this->getPaginator()->paginate(
            $results, $request->query->get('page', 1), $this->getLimit()
            , array('pageParameterName' => 'page', 'sortFieldParameterName' => 'sort', 'sortDirectionParameterName' => 'direction', 'defaultSortFieldName' => $this->getDefaultSortFieldName(), 'defaultSortDirection' => $this->getDefaultSortDirection())
        );

        $pagination->setParam('term', $this->parseTerm($request));
        $pagination->setCustomParameters([
            'align' => 'center',
            'style' => 'bottom',
        ]);
        return $pagination;
    }

    /**
     * @return PaginatorInterface
     */
    public function getPaginator(): PaginatorInterface
    {
        return $this->paginator;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return FrontendController
     */
    public function setLimit(int $limit): FrontendController
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultSortFieldName(): string
    {
        return $this->defaultSortFieldName;
    }

    /**
     * @param string $defaultSortFieldName
     * @return FrontendController
     */
    public function setDefaultSortFieldName(string $defaultSortFieldName): FrontendController
    {
        $this->defaultSortFieldName = $defaultSortFieldName;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultSortDirection(): string
    {
        return $this->defaultSortDirection;
    }

    /**
     * @param string $defaultSortDirection
     * @return FrontendController
     */
    public function setDefaultSortDirection(string $defaultSortDirection): FrontendController
    {
        $this->defaultSortDirection = $defaultSortDirection;
        return $this;
    }

    /**
     * @param Request $request
     * @param string $term
     * @param PaginatedFinderInterface $finder
     * @return JsonResponse
     */
    public function searchAutocompleteEntity(Request $request, PaginatedFinderInterface $finder, string $term = ''): JsonResponse
    {
        if (!$term) {
            $term = $request->get('term') ?? $request->get('q') ?? '*';
        }

        $results = $finder->find($term . ' && active:"true"');

        $array = (new ArrayCollection($results))->map(static function ($element) {
            return ['id' => $element->getId(), 'text' => (string)$element];
        });
        return new JsonResponse($array->toArray());
    }

    /**
     * @param AbstractType $form
     * @return array
     */
    public function newEntity(AbstractType $form): array
    {
        return array('form' => $this->getFormFactory()->create(get_class($form), null, ['frontend' => true, 'method' => Request::METHOD_POST])->createView());
    }

    /**
     * @return FormFactoryInterface
     */
    public function getFormFactory(): FormFactoryInterface
    {
        return $this->form_factory;
    }

    /**
     * @param EntityApiInterface $object
     * @param AbstractType $form
     * @return array
     */
    public function editEntity(EntityApiInterface $object, AbstractType $form): array
    {
        return array('form' => $this->getFormFactory()->create(get_class($form), $object, ['frontend' => true, 'method' => Request::METHOD_PATCH])->createView());
    }

    /**
     * @param EntityApiInterface $object
     * @return array|EntityApiInterface[]
     */
    public function detailEntity(EntityApiInterface $object): array
    {
        return array('object' => $object);
    }


}
