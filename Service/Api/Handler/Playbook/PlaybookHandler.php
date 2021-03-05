<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

/**
 * Description of PlaybookHandler
 *
 * @author asanchezg
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler\Playbook;

use CertUnlp\NgenBundle\Form\Playbook\PlaybookType;
use CertUnlp\NgenBundle\Repository\Playbook\PlaybookRepository;
use CertUnlp\NgenBundle\Service\Api\Handler\Handler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class PlaybookHandler extends Handler
{
    public function __construct(EntityManagerInterface $entity_manager, PlaybookRepository $repository, PlaybookType $entity_type, FormFactoryInterface $form_factory)
    {
        parent::__construct($entity_manager, $repository, $entity_type, $form_factory);
    }

    /**
     * {@inheritDoc}
     */
    public function getParamIdentificationArray(array $parameters): array
    {
        return ['type' => $parameters['type'], 'name' => $parameters['name']];
    }
}
