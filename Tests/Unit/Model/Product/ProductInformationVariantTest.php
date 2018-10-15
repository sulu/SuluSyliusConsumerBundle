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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationVariant;

class ProductInformationVariantTest extends TestCase
{
    public function testGetProduct(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $dimension->getId()->willReturn('dimension-1');

        $product = $this->prophesize(ProductInformation::class);
        $product->getCode()->willReturn('product-1');
        $product->getDimension()->willReturn($dimension->reveal());

        $variant = new ProductInformationVariant($product->reveal(), 'variant-1');

        $this->assertEquals($product->reveal(), $variant->getProduct());
    }

    public function testGetCode(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $dimension->getId()->willReturn('dimension-1');

        $product = $this->prophesize(ProductInformation::class);
        $product->getCode()->willReturn('product-1');
        $product->getDimension()->willReturn($dimension->reveal());

        $variant = new ProductInformationVariant($product->reveal(), 'variant-1');

        $this->assertEquals('variant-1', $variant->getCode());
    }

    public function testGetName(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $dimension->getId()->willReturn('dimension-1');

        $product = $this->prophesize(ProductInformation::class);
        $product->getCode()->willReturn('product-1');
        $product->getDimension()->willReturn($dimension->reveal());

        $variant = new ProductInformationVariant($product->reveal(), 'variant-1');

        $this->assertEquals('', $variant->getName());
    }

    public function testSetName(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $dimension->getId()->willReturn('dimension-1');

        $product = $this->prophesize(ProductInformation::class);
        $product->getCode()->willReturn('product-1');
        $product->getDimension()->willReturn($dimension->reveal());

        $variant = new ProductInformationVariant($product->reveal(), 'variant-1');

        $this->assertEquals($variant, $variant->setName('Sulu is awesome'));
        $this->assertEquals('Sulu is awesome', $variant->getName());
    }
}
