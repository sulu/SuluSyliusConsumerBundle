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
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductData;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataVariantInterface;

class ProductDataTest extends TestCase
{
    public function testGetDimension(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = new ProductData('product-1', $dimension->reveal());

        $this->assertEquals($dimension->reveal(), $product->getDimension());
    }

    public function testGetCode(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = new ProductData('product-1', $dimension->reveal());

        $this->assertEquals('product-1', $product->getCode());
    }

    public function testGetVariants(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $variant = $this->prophesize(ProductDataVariantInterface::class);

        $product = new ProductData('product-1', $dimension->reveal(), ['variant-1' => $variant->reveal()]);

        $this->assertEquals([$variant->reveal()], $product->getVariants());
    }

    public function testFindVariantByCode(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $variant = $this->prophesize(ProductDataVariantInterface::class);

        $product = new ProductData('product-1', $dimension->reveal(), ['variant-1' => $variant->reveal()]);

        $this->assertEquals($variant->reveal(), $product->findVariantByCode('variant-1'));
    }

    public function testFindVariantByCodeNotFound(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $variant = $this->prophesize(ProductDataVariantInterface::class);

        $product = new ProductData('product-1', $dimension->reveal(), ['variant-1' => $variant->reveal()]);

        $this->assertNull($product->findVariantByCode('variant-2'));
    }

    public function testAddVariant(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $variant = $this->prophesize(ProductDataVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');

        $product = new ProductData('product-1', $dimension->reveal());
        $this->assertEquals($product, $product->addVariant($variant->reveal()));

        $this->assertEquals([$variant->reveal()], $product->getVariants());
    }

    public function testRemoveVariant(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $variant = $this->prophesize(ProductDataVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');

        $product = new ProductData('product-1', $dimension->reveal(), ['variant-1' => $variant->reveal()]);
        $this->assertEquals($product, $product->removeVariant($variant->reveal()));

        $this->assertEmpty($product->getVariants());
    }

    public function testGetName(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = new ProductData('product-1', $dimension->reveal());

        $this->assertEquals('', $product->getName());
    }

    public function testSetName(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = new ProductData('product-1', $dimension->reveal());

        $this->assertEquals($product, $product->setName('Sulu is awesome'));
        $this->assertEquals('Sulu is awesome', $product->getName());
    }
}
