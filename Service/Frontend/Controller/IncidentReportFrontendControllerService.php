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

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Form\IncidentReportType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class IncidentReportFrontendControllerService extends FrontendControllerService
{

    /**
     * IncidentReportFrontendControllerService constructor.
     * @param FormFactoryInterface $formFactory
     * @param IncidentReportType $entity_type
     * @param PaginatorInterface $paginator
     * @param PaginatedFinderInterface $elastica_finder_report
     */
    public function __construct(FormFactoryInterface $formFactory, IncidentReportType $entity_type, PaginatorInterface $paginator, PaginatedFinderInterface $elastica_finder_report)
    {
        parent::__construct($formFactory, $entity_type, $paginator, $elastica_finder_report);
    }

    /**
     * @param Request $request
     * @param string $default_type
     * @return array
     */
    public function newEntity(Request $request, string $default_type = ''): array
    {
        return array('form' => $this->getFormFactory()->create($this->getEntityType())->createView(), 'method' => Request::METHOD_POST, 'default_type' => $default_type);
    }

    /**
     * @param Entity $object
     * @param string $default_type
     * @return array
     */
    public function editEntity(Entity $object, string $default_type = ''): array
    {

        return array('form' => $this->getFormFactory()->create($this->getEntityType(), $object)->createView(), 'method' => Request::METHOD_PATCH, 'default_type' => $default_type);
    }

}
