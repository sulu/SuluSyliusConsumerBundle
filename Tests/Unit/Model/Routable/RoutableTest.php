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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Routable;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\RouteBundle\Model\RouteInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\Routable;

class RoutableTest extends TestCase
{
    public function testGetDimension(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $routable = new Routable($dimension->reveal(), ProductInterface::RESOURCE_KEY, 'product-1');

        $this->assertEquals($dimension->reveal(), $routable->getDimension());
    }

    public function testGetResourceKey(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $routable = new Routable($dimension->reveal(), ProductInterface::RESOURCE_KEY, 'product-1');

        $this->assertEquals(ProductInterface::RESOURCE_KEY, $routable->getResourceKey());
    }

    public function testGetResourceId(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $routable = new Routable($dimension->reveal(), ProductInterface::RESOURCE_KEY, 'product-1');

        $this->assertEquals('product-1', $routable->getResourceId());
    }

    public function testGetId(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $routable = new Routable($dimension->reveal(), ProductInterface::RESOURCE_KEY, 'product-1');

        $this->assertEquals('product-1', $routable->getId());
    }

    public function testGetLocale(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $routable = new Routable($dimension->reveal(), ProductInterface::RESOURCE_KEY, 'product-1');

        $dimension->getAttributeValue('locale')->willReturn('en');

        $this->assertEquals('en', $routable->getLocale());
    }

    public function testGetRoute(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $routable = new Routable($dimension->reveal(), ProductInterface::RESOURCE_KEY, 'product-1');

        $this->assertNull($routable->getRoute());
    }

    public function testSetRoute(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $routable = new Routable($dimension->reveal(), ProductInterface::RESOURCE_KEY, 'product-1');

        $route = $this->prophesize(RouteInterface::class);
        $this->assertEquals($routable, $routable->setRoute($route->reveal()));

        $this->assertEquals($route->reveal(), $routable->getRoute());
    }
}
