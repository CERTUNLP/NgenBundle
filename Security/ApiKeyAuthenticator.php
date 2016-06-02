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

use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use CertUnlp\NgenBundle\Security\ApiKeyUserProvider;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface {

    protected $userProvider;

    public function __construct(ApiKeyUserProvider $userProvider) {
        $this->userProvider = $userProvider;
    }

    public function createToken(Request $request, $providerKey) {
        // look for an apikey query parameter

        if ($request->headers->get('apikey')) {
            $apiKey = $request->headers->get('apikey');
        } elseif ($request->request->get('apiKey')) {
            $apiKey = $request->request->get('apiKey');
        } else {
            $apiKey = $request->query->get('apikey');
        }
        // or if you want to use an "apikey" header, then do something like this:
        // $apiKey = $request->headers->get('apikey');

        if (!$apiKey) {
            throw new BadCredentialsException('No API key found');

            // or to just skip api key authentication
            // return null;
        }

        return new PreAuthenticatedToken(
                'anon.', $apiKey, $providerKey
        );
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey) {
        $apiKey = $token->getCredentials();
        $username = $this->userProvider->getUsernameForApiKey($apiKey);

        if (!$username) {
            throw new AuthenticationException(
            sprintf('API Key "%s" does not exist.', $apiKey)
            );
        }

        $user = $this->userProvider->loadUserByUsername($username);

        return new PreAuthenticatedToken(
                $user, $apiKey, $providerKey, $user->getRoles()
        );
    }

    public function supportsToken(TokenInterface $token, $providerKey) {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

}
