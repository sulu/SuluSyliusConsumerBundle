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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product\View;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\RouteBundle\Model\RouteInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceRepositoryInterface;

class ProductViewFactoryTest extends TestCase
{
    public function testCreate()
    {
        $contentRepository = $this->prophesize(ContentRepositoryInterface::class);
        $routableResourceRepository = $this->prophesize(RoutableResourceRepositoryInterface::class);
        $contentViewFactory = $this->prophesize(ContentViewFactoryInterface::class);

        $factory = new ProductViewFactory(
            $contentRepository->reveal(),
            $routableResourceRepository->reveal(),
            $contentViewFactory->reveal()
        );

        $dimension = $this->prophesize(DimensionInterface::class);

        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productInformation->getDimension()->willReturn($dimension->reveal());
        $productInformation->getProductId()->willReturn('123-123-123');
        $productInformation->getProductCode()->willReturn('product-1');
        $productInformation->getName()->willReturn('Product One');

        $content = $this->prophesize(ContentInterface::class);
        $content->getDimension()->willReturn($dimension->reveal());
        $content->getResourceKey()->willReturn(ProductInterface::RESOURCE_KEY);
        $content->getResourceId()->willReturn('123-123-123');
        $contentRepository->findByDimensions(ProductInterface::RESOURCE_KEY, '123-123-123', [$dimension->reveal()])
            ->willReturn([$content->reveal()]);

        $route = $this->prophesize(RouteInterface::class);
        $route->getPath()->willReturn('/test');
        $routable = $this->prophesize(RoutableResourceInterface::class);
        $routable->getRoute()->willReturn($route->reveal());
        $routableResourceRepository->findOrCreateByResource(
            ProductInterface::RESOURCE_KEY,
            '123-123-123',
            $dimension->reveal()
        )->willReturn($routable->reveal());

        $viewContent = $this->prophesize(ContentInterface::class);
        $viewContent->getData()->willReturn(['title' => 'Sulu is awesome']);
        $viewContent->getType()->willReturn('default');
        $contentViewFactory->create([$content->reveal()])->willReturn($viewContent->reveal());

        $result = $factory->create($productInformation->reveal(), [$dimension->reveal()]);

        $this->assertInstanceOf(ProductViewInterface::class, $result);
        $this->assertEquals('123-123-123', $result->getId());
        $this->assertEquals('product-1', $result->getCode());
        $this->assertEquals('Product One', $result->getName());
        $this->assertEquals('default', $result->getContentType());
        $this->assertEquals(['title' => 'Sulu is awesome'], $result->getContentData());
        $this->assertEquals('/test', $result->getRoutePath());
    }
}
