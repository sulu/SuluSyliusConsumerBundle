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
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;

class ProductTest extends TestCase
{
    public function testGetDimension(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = new Product($dimension->reveal(), 'product-1');

        $this->assertEquals($dimension->reveal(), $product->getDimension());
    }

    public function testGetCode(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = new Product($dimension->reveal(), 'product-1');

        $this->assertEquals('product-1', $product->getCode());
    }

    public function testGetVariants(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $variant = $this->prophesize(ProductVariantInterface::class);

        $product = new Product($dimension->reveal(), 'product-1', ['variant-1' => $variant->reveal()]);

        $this->assertEquals([$variant->reveal()], $product->getVariants());
    }

    public function testFindVariantByCode(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $variant = $this->prophesize(ProductVariantInterface::class);

        $product = new Product($dimension->reveal(), 'product-1', ['variant-1' => $variant->reveal()]);

        $this->assertEquals($variant->reveal(), $product->findVariantByCode('variant-1'));
    }

    public function testFindVariantByCodeNotFound(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $variant = $this->prophesize(ProductVariantInterface::class);

        $product = new Product($dimension->reveal(), 'product-1', ['variant-1' => $variant->reveal()]);

        $this->assertNull($product->findVariantByCode('variant-2'));
    }

    public function testAddVariant(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $variant = $this->prophesize(ProductVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');

        $product = new Product($dimension->reveal(), 'product-1');
        $this->assertEquals($product, $product->addVariant($variant->reveal()));

        $this->assertEquals([$variant->reveal()], $product->getVariants());
    }

    public function testRemoveVariant(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $variant = $this->prophesize(ProductVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');

        $product = new Product($dimension->reveal(), 'product-1', ['variant-1' => $variant->reveal()]);
        $this->assertEquals($product, $product->removeVariant($variant->reveal()));

        $this->assertEmpty($product->getVariants());
    }

    public function testGetContent(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = new Product($dimension->reveal(), 'product-1');

        $this->assertNull($product->getContent());
    }

    public function testSetContent(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = new Product($dimension->reveal(), 'product-1');

        $content = $this->prophesize(ContentInterface::class);
        $this->assertEquals($product, $product->setContent($content->reveal()));

        $this->assertEquals($content->reveal(), $product->getContent());
    }

    public function testGetRoutable(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = new Product($dimension->reveal(), 'product-1');

        $this->assertNull($product->getRoutable());
    }

    public function testSetRoutable(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = new Product($dimension->reveal(), 'product-1');

        $routable = $this->prophesize(RoutableResourceInterface::class);
        $this->assertEquals($product, $product->setRoutable($routable->reveal()));

        $this->assertEquals($routable->reveal(), $product->getRoutable());
    }
}
