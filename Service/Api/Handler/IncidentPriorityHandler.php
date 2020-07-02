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

use CertUnlp\NgenBundle\Form\IncidentPriorityType;
use CertUnlp\NgenBundle\Repository\IncidentPriorityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class IncidentPriorityHandler extends Handler
{

    public function __construct(EntityManagerInterface $entity_manager, IncidentPriorityRepository $repository, IncidentPriorityType $entity_ype, FormFactoryInterface $form_factory)
    {
        parent::__construct($entity_manager, $repository, $entity_ype, $form_factory);
    }

    /**
     * {@inheritDoc}
     */
    public function getParamIdentificationArray(array $parameters): array
    {
        return ['impact' => $parameters['impact'],'urgency'=> $parameters['urgency']];
    }

}