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

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;

class SyliusUser implements SyliusUserInterface
{
    /**
     * @var Customer
     */
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer(): Customer
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
}
