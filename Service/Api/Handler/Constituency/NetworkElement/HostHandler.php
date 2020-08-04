<?php
/**
 * This file is part of the Ngen - CSIRT Incident Report System.
 *   (c) CERT UNLP <support@cert.unlp.edu.ar>
 *  This source file is subject to the GPL v3.0 license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Service\Api\Handler\Constituency\NetworkElement;

use CertUnlp\NgenBundle\Form\Constituency\NetworkElement\HostType;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
use CertUnlp\NgenBundle\Repository\HostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class HostHandler extends NetworkElementHandler
{
    public function __construct(EntityManagerInterface $entity_manager, HostRepository $repository, HostType $entity_type, FormFactoryInterface $form_factory)
    {
        parent::__construct($entity_manager, $repository, $entity_type, $form_factory);
    }
    /**
     * @param array $parameters
     * @return EntityApiInterface
     */
    public function createEntityInstance(array $parameters = []): EntityApiInterface
    {
        $class_name = $this->getRepository()->getClassName();
        return new $class_name($parameters['address']);
    }
}
