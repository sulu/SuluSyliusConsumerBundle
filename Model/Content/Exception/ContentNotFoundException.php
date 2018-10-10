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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Content\Exception;

use Sulu\Bundle\SyliusConsumerBundle\Model\ModelNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;

class ContentNotFoundException extends ModelNotFoundException
{
    public function __construct(string $resourceKey, string $resourceId, $code = 0, \Throwable $previous = null)
    {
        parent::__construct(Product::class, sprintf('%s#%s', $resourceKey, $resourceId), $code, $previous);
    }
}
