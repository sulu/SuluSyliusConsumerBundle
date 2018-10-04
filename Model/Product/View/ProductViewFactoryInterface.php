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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\View;

use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;

interface ProductViewFactoryInterface
{
    /**
     * @param ProductInterface[] $productDimensions
     * @param DimensionInterface[] $dimensions
     */
    public function create(array $productDimensions, array $dimensions): ProductInterface;
}
