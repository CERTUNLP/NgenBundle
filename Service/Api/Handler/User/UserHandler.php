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

namespace CertUnlp\NgenBundle\Service\Api\Handler\User;

use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Form\User\UserType;
use CertUnlp\NgenBundle\Model\EntityApiInterface;
use CertUnlp\NgenBundle\Repository\User\UserRepository;
use CertUnlp\NgenBundle\Service\Api\Handler\Handler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class UserHandler extends Handler
{

    /**
     * UserHandler constructor.
     * @param EntityManagerInterface $entity_manager
     * @param UserRepository $repository
     * @param UserType $entity_ype
     * @param FormFactoryInterface $form_factory
     */
    public function __construct(EntityManagerInterface $entity_manager, UserRepository $repository, UserType $entity_ype, FormFactoryInterface $form_factory)
    {
        parent::__construct($entity_manager, $repository, $entity_ype, $form_factory);
    }

    /**
     * @param array $parameters
     * @return EntityApiInterface| User
     */
    public function createEntityInstance(array $parameters = []): EntityApiInterface
    {
        /** @var User $user */
        $user = parent::createEntityInstance($parameters);
        $user->setEnabled(true);
        $user->setApiKey(sha1($user->getUsername() . time() . $user->getSalt()));
        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getParamIdentificationArray(array $parameters): array
    {
        return ['username' => $parameters['username']];
    }
}
