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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception;

use Sulu\Bundle\SyliusConsumerBundle\Model\ModelNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariant;

class ProductVariantNotFoundException extends ModelNotFoundException
{
    public function __construct(string $id, $code = 0, \Throwable $previous = null)
    {
        parent::__construct(ProductVariant::class, $id, $code, $previous);
    }
}
