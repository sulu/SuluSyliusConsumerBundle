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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Routable\Handler\Message;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\RouteBundle\Manager\RouteManagerInterface;
use Sulu\Bundle\RouteBundle\Model\RouteInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\Handler\Message\PublishRoutableMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\Message\PublishRoutableMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\RoutableInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\RoutableRepositoryInterface;

class PublishRoutableMessageHandlerTest extends TestCase
{
    public function testInvokeUpdate(): void
    {
        $routableRepository = $this->prophesize(RoutableRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $routeManager = $this->prophesize(RouteManagerInterface::class);

        $handler = new PublishRoutableMessageHandler(
            $routableRepository->reveal(), $dimensionRepository->reveal(), $routeManager->reveal()
        );

        $message = $this->prophesize(PublishRoutableMessage::class);
        $message->getResourceKey()->willReturn(ProductInterface::RESOURCE_KEY);
        $message->getResourceId()->willReturn('product-1');
        $message->getLocale()->willReturn('en');
        $message->getRoutePath()->willReturn('/products/product-1');

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($dimension->reveal());

        $routable = $this->prophesize(RoutableInterface::class);
        $routableRepository->findOrCreateByResource(ProductInterface::RESOURCE_KEY, 'product-1', $dimension->reveal())
            ->willReturn($routable->reveal());

        $route = $this->prophesize(RouteInterface::class);
        $routable->getRoute()->willReturn($route->reveal());

        $routeManager->update($routable->reveal(), '/products/product-1')->shouldBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeCreate(): void
    {
        $routableRepository = $this->prophesize(RoutableRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $routeManager = $this->prophesize(RouteManagerInterface::class);

        $handler = new PublishRoutableMessageHandler(
            $routableRepository->reveal(), $dimensionRepository->reveal(), $routeManager->reveal()
        );

        $message = $this->prophesize(PublishRoutableMessage::class);
        $message->getResourceKey()->willReturn(ProductInterface::RESOURCE_KEY);
        $message->getResourceId()->willReturn('product-1');
        $message->getLocale()->willReturn('en');
        $message->getRoutePath()->willReturn('/products/product-1');

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn(
            $dimension->reveal()
        );

        $routable = $this->prophesize(RoutableInterface::class);
        $routableRepository->findOrCreateByResource(ProductInterface::RESOURCE_KEY, 'product-1', $dimension->reveal())->willReturn(
            $routable->reveal()
        );

        $routable->getRoute()->willReturn(null);

        $routeManager->create($routable->reveal(), '/products/product-1')->shouldBeCalled();

        $handler->__invoke($message->reveal());
    }
}
