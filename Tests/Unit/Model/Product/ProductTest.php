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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;

class ProductTest extends TestCase
{
    public function testGetCode(): void
    {
        $product = new Product('product-1');

        $this->assertEquals('product-1', $product->getCode());
    }

    public function testGetVariants(): void
    {
        $variant = $this->prophesize(ProductVariantInterface::class);

        $product = new Product('product-1', ['variant-1' => $variant->reveal()]);

        $this->assertEquals([$variant->reveal()], $product->getVariants());
    }

    public function testFindVariantByCode(): void
    {
        $variant = $this->prophesize(ProductVariantInterface::class);

        $product = new Product('product-1', ['variant-1' => $variant->reveal()]);

        $this->assertEquals($variant->reveal(), $product->findVariantByCode('variant-1'));
    }

    public function testFindVariantByCodeNotFound(): void
    {
        $variant = $this->prophesize(ProductVariantInterface::class);

        $product = new Product('product-1', ['variant-1' => $variant->reveal()]);

        $this->assertNull($product->findVariantByCode('variant-2'));
    }

    public function testAddVariant(): void
    {
        $variant = $this->prophesize(ProductVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');

        $product = new Product('product-1');
        $this->assertEquals($product, $product->addVariant($variant->reveal()));

        $this->assertEquals([$variant->reveal()], $product->getVariants());
    }

    public function testRemoveVariant(): void
    {
        $variant = $this->prophesize(ProductVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');

        $product = new Product('product-1', ['variant-1' => $variant->reveal()]);
        $this->assertEquals($product, $product->removeVariant($variant->reveal()));

        $this->assertEmpty($product->getVariants());
    }
}
