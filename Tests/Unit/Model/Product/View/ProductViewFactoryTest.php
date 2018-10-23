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
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceRepositoryInterface;

class ProductViewFactoryTest extends TestCase
{
    public function testCreate()
    {
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $routableResourceRepository = $this->prophesize(RoutableResourceRepositoryInterface::class);
        $contentViewFactory = $this->prophesize(ContentViewFactoryInterface::class);

        $factory = new ProductViewFactory(
            $dimensionRepository->reveal(),
            $productInformationRepository->reveal(),
            $routableResourceRepository->reveal(),
            $contentViewFactory->reveal()
        );

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimension->hasAttribute('locale')->willReturn(true);
        $dimension->getAttributeValue('locale')->willReturn('de');

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $product->getCode()->willReturn('product-1');

        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productInformation->getDimension()->willReturn($dimension->reveal());
        $productInformation->getProductId()->willReturn('123-123-123');
        $productInformation->getProductCode()->willReturn('product-1');
        $productInformation->getName()->willReturn('Product One');
        $productInformationRepository->findByProductId('123-123-123', $dimension->reveal())
            ->willReturn($productInformation->reveal());

        $contentView = $this->prophesize(ContentViewInterface::class);
        $contentView->getResourceKey()->willReturn(ProductInterface::RESOURCE_KEY);
        $contentView->getResourceId()->willReturn('123-123-123');
        $contentViewFactory->loadAndCreate(ProductInterface::RESOURCE_KEY, '123-123-123', [$dimension->reveal()])
            ->willReturn($contentView->reveal());

        $route = $this->prophesize(RouteInterface::class);
        $route->getPath()->willReturn('/test');
        $routable = $this->prophesize(RoutableResourceInterface::class);
        $routable->getRoute()->willReturn($route->reveal());
        $routableResourceRepository->findByResource(
            ProductInterface::RESOURCE_KEY,
            '123-123-123',
            $dimension->reveal()
        )->willReturn($routable->reveal());

        $result = $factory->create($product->reveal(), [$dimension->reveal()]);

        $this->assertInstanceOf(ProductViewInterface::class, $result);
        $this->assertEquals($product->reveal(), $result->getProduct());
        $this->assertEquals($productInformation->reveal(), $result->getProductInformation());
        $this->assertEquals($contentView->reveal(), $result->getContent());
        $this->assertEquals($routable->reveal(), $result->getRoutableResource());
    }
}
