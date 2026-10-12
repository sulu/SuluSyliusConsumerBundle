<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Adapter\Product;

final class ProductContent
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $url = null,
        public readonly ?string $shortDescription = null,
        public readonly ?string $description = null,
    ) {
    }
}
