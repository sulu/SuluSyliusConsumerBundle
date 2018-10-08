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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariant;

class ProductVariantTest extends TestCase
{
    public function testGetProduct(): void
    {
        $product = $this->prophesize(Product::class);
        $variant = new ProductVariant($product->reveal(), 'variant-1');

        $this->assertEquals($product->reveal(), $variant->getProduct());
    }

    public function testGetCode(): void
    {
        $product = $this->prophesize(Product::class);
        $variant = new ProductVariant($product->reveal(), 'variant-1');

        $this->assertEquals('variant-1', $variant->getCode());
    }
}
