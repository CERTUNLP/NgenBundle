<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Security;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{

    private $om;
    private $repository;

    public function __construct(ObjectManager $om, $user_class)
    {
        $this->om = $om;
        $this->repository = $this->om->getRepository($user_class);
    }

    public function getUsernameForApiKey($apiKey)
    {

        $user = $this->repository->findOneByApiKey($apiKey);
        return $user;
    }

    public function loadUserByUsername($user)
    {
        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return 'CertUnlp\NgenBundle\Entity\User' === $class;
    }

}
