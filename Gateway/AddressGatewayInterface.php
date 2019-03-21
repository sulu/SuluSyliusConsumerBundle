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

use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressInterface;

interface AddressGatewayInterface
{
    public function findByCustomer(int $customerId, int $limit = 10, int $page = 1): array;

    public function findById(int $id): array;

    public function create(int $customerId, AddressInterface $address): array;

    public function update(AddressInterface $address): void;

    public function remove(int $id): void;
}
