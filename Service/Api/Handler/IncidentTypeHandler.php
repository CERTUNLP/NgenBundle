<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler;

use CertUnlp\NgenBundle\Entity\Entity;
use CertUnlp\NgenBundle\Entity\Incident\IncidentType;
use CertUnlp\NgenBundle\Form\IncidentTypeType;
use CertUnlp\NgenBundle\Repository\IncidentTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class IncidentTypeHandler extends Handler
{

    /**
     * @var IncidentReportHandler
     */
    private $report_handler;

    public function __construct(EntityManagerInterface $entity_manager, IncidentTypeRepository $repository, IncidentTypeType $entity_ype, FormFactoryInterface $form_factory, IncidentReportHandler $report_handler)
    {
        parent::__construct($entity_manager, $repository, $entity_ype, $form_factory);
        $this->report_handler = $report_handler;
    }

    /**
     * @param Entity|IncidentType $entity
     * @param array|null $parameters
     * @return Entity
     */
    public function patch(Entity $entity, array $parameters = null): Entity
    {
        if (isset($parameters['report'])) {
            $report = $this->getReportHandler()->post($parameters['report']);
            $report->setType($entity);
        }

        return parent::patch($entity, $parameters);
    }

    /**
     * @return IncidentReportHandler
     */
    public function getReportHandler(): IncidentReportHandler
    {
        return $this->report_handler;
    }

}
