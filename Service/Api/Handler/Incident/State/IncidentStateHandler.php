<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler\Incident\State;

use CertUnlp\NgenBundle\Entity\Incident\State\IncidentState;
use CertUnlp\NgenBundle\Form\Incident\State\IncidentStateType;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
use CertUnlp\NgenBundle\Repository\Incident\State\IncidentStateRepository;
use CertUnlp\NgenBundle\Service\Api\Handler\Handler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class IncidentStateHandler extends Handler
{

    public function __construct(EntityManagerInterface $entity_manager, IncidentStateRepository $repository, IncidentStateType $entity_ype, FormFactoryInterface $form_factory)
    {
        parent::__construct($entity_manager, $repository, $entity_ype, $form_factory);
    }

    /**
     * @return IncidentState|EntityApiInterface
     */
    public function getInitialState(): IncidentState
    {
        return $this->get(['slug' => 'initial']);
    }

    /**
     * {@inheritDoc}
     */
    public function getParamIdentificationArray(array $parameters): array
    {
        return ['name' => $parameters['name']];
    }
}
