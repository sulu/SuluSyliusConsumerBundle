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

use Sulu\Bundle\SyliusConsumerBundle\Gateway\AuthenticationGatewayInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SyliusUserProvider implements UserProviderInterface
{
    /**
     * @var AuthenticationGatewayInterface
     */
    private $authenticationGateway;

    public function __construct(AuthenticationGatewayInterface $authenticationGateway)
    {
        $this->authenticationGateway = $authenticationGateway;
    }

    public function loadUserByUsername($username)
    {
        throw new \Exception('load');
    }

    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    public function supportsClass($class)
    {
        return is_subclass_of($class, UserInterface::class);
    }
}
