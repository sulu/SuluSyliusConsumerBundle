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

use Sulu\Bundle\SyliusConsumerBundle\Gateway\CustomerGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Gateway\Exception\NotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SyliusUserProvider implements UserProviderInterface
{
    /**
     * @var CustomerGatewayInterface
     */
    private $customerGateway;

    public function __construct(CustomerGatewayInterface $customerGateway)
    {
        $this->customerGateway = $customerGateway;
    }

    public function loadUserByUsername($username)
    {
        throw new \Exception('"loadUserByUsername" method is not implemented');
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof SyliusUserInterface) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', \get_class($user))
            );
        }

        try {
            $customer = $this->customerGateway->findById($user->getCustomer()->getId());
        } catch (NotFoundException $exception) {
            throw new UsernameNotFoundException(
                sprintf('Customer with id %s not found', json_encode($user->getCustomer()->getId()))
            );
        }

        return new SyliusUser($customer);
    }

    public function supportsClass($class)
    {
        return is_subclass_of($class, SyliusUserInterface::class);
    }
}
