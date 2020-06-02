<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

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
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends AbstractController
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
     * FrontendControllerService constructor.
     * @param FormFactoryInterface $formFactory
     * @param PaginatorInterface $paginator
     */
    public function __construct(FormFactoryInterface $formFactory, PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
        $this->form_factory = $formFactory;

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
     * @param string $term
     * @param int $limit
     * @param string $defaultSortFieldName
     * @param string $defaultSortDirection
     * @return array
     */
    public function homeEntity(Request $request, PaginatedFinderInterface $finder, string $term = '', int $limit = 7, string $defaultSortFieldName = 'createdAt', string $defaultSortDirection = 'desc'): array
    {
        return $this->searchEntity($request, $finder, $term, $limit, $defaultSortFieldName, $defaultSortDirection);
    }

    /**
     * @param Request $request
     * @param PaginatedFinderInterface $finder
     * @param string $term
     * @param int $limit
     * @param string $defaultSortFieldName
     * @param string $defaultSortDirection
     * @param string $page
     * @param string $field
     * @return array
     */
    public function searchEntity(Request $request, PaginatedFinderInterface $finder, string $term = '', int $limit = 7, string $defaultSortFieldName = 'createdAt', string $defaultSortDirection = 'desc', string $page = 'page', string $field = ''): array
    {
        if (!$term) {
            $term = $request->get('term') ?: '*';
        }
        $results = $finder->createPaginatorAdapter($term);
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
     * @return PaginatorInterface
     */
    public function getPaginator(): PaginatorInterface
    {
        return $this->paginator;
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
     * @param Request $request
     * @param AbstractType $form
     * @return array
     */
    public function newEntity(Request $request, AbstractType $form): array
    {
        return array('form' => $this->getFormFactory()->create(get_class($form))->createView(), 'method' => 'POST');
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
        return array('form' => $this->getFormFactory()->create(get_class($form), $object)->createView(), 'method' => 'patch');
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
