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

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Form\IncidentReportType;
use Doctrine\Persistence\ManagerRegistry;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentReportFrontendController extends FrontendController
{

    /**
     * IncidentReportFrontendController constructor.
     * @param ManagerRegistry $doctrine
     * @param FormFactoryInterface $formFactory
     * @param IncidentReportType $entity_type
     * @param PaginatorInterface $paginator
     * @param PaginatedFinderInterface $elastica_finder_report
     */
    public function __construct(ManagerRegistry $doctrine, FormFactoryInterface $formFactory, IncidentReportType $entity_type, PaginatorInterface $paginator, PaginatedFinderInterface $elastica_finder_report)
    {
        parent::__construct($doctrine, $formFactory, $entity_type, $paginator, $elastica_finder_report);
    }

    /**
     * @param Request $request
     * @param string $default_type
     * @return array
     */
    public function newEntity(Request $request, string $default_type = ''): array
    {
        return array('form' => $this->getFormFactory()->create($this->getEntityType())->createView(), 'method' => 'POST', 'default_type' => $default_type);
    }

    /**
     * @param Entity $object
     * @param string $default_type
     * @return array
     */
    public function editEntity(Entity $object, string $default_type = ''): array
    {

        return array('form' => $this->getFormFactory()->create($this->getEntityType(), $object)->createView(), 'method' => 'patch', 'default_type' => $default_type);
    }

}
