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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformation;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;

class ProductInformationTest extends TestCase
{
    public function testGetDimension(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = $this->prophesize(ProductInterface::class);
        $productInformation = new ProductInformation($product->reveal(), $dimension->reveal());

        $this->assertEquals($dimension->reveal(), $productInformation->getDimension());
    }

    public function testGetProductId(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $productInformation = new ProductInformation($product->reveal(), $dimension->reveal());

        $this->assertEquals('123-123-123', $productInformation->getProductId());
    }

    public function testGetVariants(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = $this->prophesize(ProductInterface::class);
        $variant = $this->prophesize(ProductInformationVariantInterface::class);

        $productInformation = new ProductInformation(
            $product->reveal(),
            $dimension->reveal(),
            ['variant-1' => $variant->reveal()]
        );

        $this->assertEquals([$variant->reveal()], $productInformation->getVariants());
    }

    public function testFindVariantByCode(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = $this->prophesize(ProductInterface::class);
        $variant = $this->prophesize(ProductInformationVariantInterface::class);

        $productInformation = new ProductInformation(
            $product->reveal(),
            $dimension->reveal(),
            ['variant-1' => $variant->reveal()]
        );

        $this->assertEquals($variant->reveal(), $productInformation->findVariantByCode('variant-1'));
    }

    public function testFindVariantByCodeNotFound(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = $this->prophesize(ProductInterface::class);
        $variant = $this->prophesize(ProductInformationVariantInterface::class);

        $productInformation = new ProductInformation(
            $product->reveal(),
            $dimension->reveal(),
            ['variant-1' => $variant->reveal()]
        );

        $this->assertNull($productInformation->findVariantByCode('variant-2'));
    }

    public function testAddVariant(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = $this->prophesize(ProductInterface::class);
        $variant = $this->prophesize(ProductInformationVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');

        $productInformation = new ProductInformation($product->reveal(), $dimension->reveal());
        $this->assertEquals($productInformation, $productInformation->addVariant($variant->reveal()));

        $this->assertEquals([$variant->reveal()], $productInformation->getVariants());
    }

    public function testRemoveVariant(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = $this->prophesize(ProductInterface::class);
        $variant = $this->prophesize(ProductInformationVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');

        $productInformation = new ProductInformation(
            $product->reveal(),
            $dimension->reveal(),
            ['variant-1' => $variant->reveal()]
        );
        $this->assertEquals($productInformation, $productInformation->removeVariant($variant->reveal()));

        $this->assertEmpty($productInformation->getVariants());
    }

    public function testGetName(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = $this->prophesize(ProductInterface::class);
        $productInformation = new ProductInformation($product->reveal(), $dimension->reveal());

        $this->assertEquals('', $productInformation->getName());
    }

    public function testSetName(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $product = $this->prophesize(ProductInterface::class);
        $productInformation = new ProductInformation($product->reveal(), $dimension->reveal());

        $this->assertEquals($productInformation, $productInformation->setName('Sulu is awesome'));
        $this->assertEquals('Sulu is awesome', $productInformation->getName());
    }
}
