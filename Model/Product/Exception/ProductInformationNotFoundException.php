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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformation;

class ProductInformationNotFoundException extends ModelNotFoundException
{
    public function __construct(string $productCode, $code = 0, \Throwable $previous = null)
    {
        parent::__construct(ProductInformation::class, $productCode, $code, $previous);
    }
}
