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

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SyliusUser implements SyliusUserInterface
{
    /**
     * @var CustomerInterface
     */
    private $customer;

    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    public function getId(): int
    {
        return $this->customer->getUser()->getId();
    }

    public function getUsername(): ?string
    {
        return $this->customer->getUser()->getUsername() ?: $this->customer->getEmailCanonical();
    }

    public function getRoles(): array
    {
        return $this->customer->getUser()->getRoles();
    }

    public function eraseCredentials(): void
    {
        return;
    }

    public function getPassword(): ?string
    {
        return null;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof SyliusUserInterface) {
            return false;
        }

        return $user->getCustomer()->getUser()->getHash() === $this->customer->getUser()->getHash();
    }
}
