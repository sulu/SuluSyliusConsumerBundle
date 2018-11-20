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

interface CartGatewayInterface
{
    public function findById(int $id): array;

    public function findByCustomerEmail(string $customerEmail): array;

    public function create(string $customer, string $channel, string $locale): array;

    public function remove(int $id): array;

    public function addItem(int $cartId, string $variantCode, int $quantity): array;

    public function modifyItem(int $cartId, int $cartItemId, int $quantity): array;

    public function removeItem(int $cartId, int $cartItemId): array;
}
