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

namespace Sulu\Bundle\SyliusConsumerBundle\Adapter;

use Sulu\Bundle\SyliusConsumerBundle\Payload\ProductVariantPayload;

interface ProductVariantAdapterInterface
{
    public function synchronize(ProductVariantPayload $payload): void;

    public function remove(string $code): void;
}
