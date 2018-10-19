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
use Sulu\Bundle\RouteBundle\Model\RouteInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductView;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;

class ProductViewTest extends TestCase
{
    public function testGetCode(): void
    {
        $productView = new ProductView('123-123-123', 'product-1');

        $this->assertEquals('product-1', $productView->getCode());
    }

    public function testGetName(): void
    {
        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productInformation->getName()->willReturn('Sulu is awesome');

        $productView = new ProductView('123-123-123', 'product-1');
        $productView->setProductInformation($productInformation->reveal());

        $this->assertEquals('Sulu is awesome', $productView->getName());
    }

    public function testGetVariants(): void
    {
        $productInformation = $this->prophesize(ProductInformationInterface::class);

        $productView = new ProductView('123-123-123', 'product-1');
        $productView->setProductInformation($productInformation->reveal());

        $this->assertEquals([], $productView->getVariants());
    }

    public function testGetContentType(): void
    {
        $content = $this->prophesize(ContentInterface::class);
        $content->getType()->willReturn('default');

        $productView = new ProductView('123-123-123', 'product-1');
        $productView->setContent($content->reveal());

        $this->assertEquals('default', $productView->getContentType());
    }

    public function testGetContentData(): void
    {
        $content = $this->prophesize(ContentInterface::class);
        $content->getData()->willReturn(['title' => 'Sulu is awesome']);

        $productView = new ProductView('123-123-123', 'product-1');
        $productView->setContent($content->reveal());

        $this->assertEquals(['title' => 'Sulu is awesome'], $productView->getContentData());
    }

    public function testGetRoutePath(): void
    {
        $route = $this->prophesize(RouteInterface::class);
        $route->getPath()->willReturn('/test');
        $routableResource = $this->prophesize(RoutableResourceInterface::class);
        $routableResource->getRoute()->willReturn($route->reveal());

        $productView = new ProductView('123-123-123', 'product-1');
        $productView->setRoutableResource($routableResource->reveal());

        $this->assertEquals('/test', $productView->getRoutePath());
    }
}
