<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Security;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\AuthenticationGateway;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class SyliusAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var AuthenticationGateway
     */
    private $authenticationGateway;

    public function __construct(AuthenticationGateway $authenticationGateway)
    {
        $this->authenticationGateway = $authenticationGateway;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        if (!$request->get('email') || !$request->get('password')) {
            return false;
        }

        return true;
    }

    public function getCredentials(Request $request)
    {
        return [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $email = $credentials['email'];
        $password = $credentials['password'];
        if (null === $email || null === $password) {
            return null;
        }

        return $this->authenticationGateway->getUser($email, $password);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent.
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            // you might translate this message
            'message' => 'Authentication Required',
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
