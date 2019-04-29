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

namespace Sulu\Bundle\SyliusConsumerBundle\Gateway;

use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\CustomerInterface;

interface CustomerGatewayInterface
{
    public function findById(int $id): CustomerInterface;

    public function create(
        string $email,
        string $plainPassword,
        string $firstName,
        string $lastName,
        string $gender,
        bool $enabled = false
    ): CustomerInterface;

    public function modify(
        string $email,
        ?string $plainPassword = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $gender = null,
        ?bool $enabled = null
    ): void;

    public function verify(string $token): CustomerInterface;
}
