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

use CertUnlp\NgenBundle\Entity\User;
use CertUnlp\NgenBundle\Repository\User\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * ApiKeyUserProvider constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @param $apiKey
     * @return User
     */
    public function getUsernameForApiKey(string $apiKey): ?User
    {
        return $this->getRepository()->findOneByApiKey($apiKey);
    }

    /**
     * @return UserRepository
     */
    public function getRepository(): UserRepository
    {
        return $this->repository;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($user)
    {
        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        throw new UnsupportedUserException('Apikey user not found');
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class): bool
    {
        return User::class === $class;
    }

}
