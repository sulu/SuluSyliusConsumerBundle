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

interface OrderGatewayInterface
{
    public function findByCustomer(
        int $customerId,
        int $limit = 10,
        int $page = 1,
        ?\DateTime $from = null,
        ?\DateTime $to = null,
        bool $inclusiveFrom = true,
        bool $inclusiveTo = false
    ): array;
}
