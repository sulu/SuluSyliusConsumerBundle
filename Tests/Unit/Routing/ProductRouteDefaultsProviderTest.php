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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Routing;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sulu\Bundle\HttpCacheBundle\CacheLifetime\CacheLifetimeResolverInterface;
use Sulu\Bundle\SyliusConsumerBundle\Controller\Product\WebsiteProductController;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductViewQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResource;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;
use Sulu\Bundle\SyliusConsumerBundle\Routing\ProductRouteDefaultsProvider;
use Sulu\Component\Content\Metadata\Factory\StructureMetadataFactoryInterface;
use Sulu\Component\Content\Metadata\StructureMetadata;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductRouteDefaultsProviderTest extends TestCase
{
    public function testGetByEntity(): void
    {
        $messageBus = $this->prophesize(MessageBusInterface::class);
        $factory = $this->prophesize(StructureMetadataFactoryInterface::class);
        $cacheLifetimeResolver = $this->prophesize(CacheLifetimeResolverInterface::class);
        $routeDefaultsFallback = [
            'view' => 'default/product/view.html.twig',
            '_controller' => 'Controller:action',
            '_cacheLifetime' => 3600,
        ];

        $provider = new ProductRouteDefaultsProvider(
            $messageBus->reveal(),
            $factory->reveal(),
            $cacheLifetimeResolver->reveal(),
            $routeDefaultsFallback
        );

        $contentView = $this->prophesize(ContentViewInterface::class);
        $contentView->getType()->willReturn('default');

        $productView = $this->prophesize(ProductViewInterface::class);
        $productView->getContent()->willReturn($contentView->reveal());

        $messageBus->dispatch(
            Argument::that(
                function (FindProductViewQuery $query) {
                    return 'product-1' === $query->getId() && 'en' === $query->getLocale();
                }
            )
        )->willReturn($productView->reveal())->shouldBeCalled();

        $metadata = $this->prophesize(StructureMetadata::class);
        $metadata->getController()->willReturn(WebsiteProductController::class);
        $metadata->getView()->willReturn('templates/product');
        $metadata->getCacheLifetime()->willReturn(['type' => 'seconds', 'value' => 3600]);

        $factory->getStructureMetadata(ProductInterface::CONTENT_RESOURCE_KEY, 'default')->willReturn($metadata->reveal());

        $cacheLifetimeResolver->supports('seconds', 3600)->willReturn(true);
        $cacheLifetimeResolver->resolve('seconds', 3600)->willReturn(3600);

        $defaults = $provider->getByEntity(RoutableResourceInterface::class, 'product-1', 'en');
        $this->assertEquals(
            [
                'object' => $productView->reveal(),
                'view' => 'templates/product',
                '_cacheLifetime' => 3600,
                '_controller' => WebsiteProductController::class,
            ],
            $defaults
        );
    }

    public function testIsPublished(): void
    {
        $messageBus = $this->prophesize(MessageBusInterface::class);
        $factory = $this->prophesize(StructureMetadataFactoryInterface::class);
        $cacheLifetimeResolver = $this->prophesize(CacheLifetimeResolverInterface::class);
        $routeDefaultsFallback = [
            'view' => 'default/product/view.html.twig',
            '_controller' => 'Controller:action',
            '_cacheLifetime' => 3600,
        ];

        $provider = new ProductRouteDefaultsProvider(
            $messageBus->reveal(),
            $factory->reveal(),
            $cacheLifetimeResolver->reveal(),
            $routeDefaultsFallback
        );

        $product = $this->prophesize(ProductInterface::class);

        $productView = $this->prophesize(ProductViewInterface::class);
        $productView->getProduct()->willReturn($product->reveal());

        $messageBus->dispatch(
            Argument::that(
                function (FindProductViewQuery $query) {
                    return 'product-1' === $query->getId() && 'en' === $query->getLocale();
                }
            )
        )->willReturn($productView->reveal())->shouldBeCalled();

        $this->assertTrue($provider->isPublished(RoutableResourceInterface::class, 'product-1', 'en'));
    }

    public function testIsNotPublished(): void
    {
        $messageBus = $this->prophesize(MessageBusInterface::class);
        $factory = $this->prophesize(StructureMetadataFactoryInterface::class);
        $cacheLifetimeResolver = $this->prophesize(CacheLifetimeResolverInterface::class);
        $routeDefaultsFallback = [
            'view' => 'default/product/view.html.twig',
            '_controller' => 'Controller:action',
            '_cacheLifetime' => 3600,
        ];

        $provider = new ProductRouteDefaultsProvider(
            $messageBus->reveal(),
            $factory->reveal(),
            $cacheLifetimeResolver->reveal(),
            $routeDefaultsFallback
        );

        $messageBus->dispatch(
            Argument::that(
                function (FindProductViewQuery $query) {
                    return 'product-1' === $query->getId() && 'en' === $query->getLocale();
                }
            )
        )->willThrow(new ProductInformationNotFoundException('product-1'))->shouldBeCalled();

        $this->assertFalse($provider->isPublished(RoutableResourceInterface::class, 'product-1', 'en'));
    }

    public function testSupports(): void
    {
        $messageBus = $this->prophesize(MessageBusInterface::class);
        $factory = $this->prophesize(StructureMetadataFactoryInterface::class);
        $cacheLifetimeResolver = $this->prophesize(CacheLifetimeResolverInterface::class);
        $routeDefaultsFallback = [
            'view' => 'default/product/view.html.twig',
            '_controller' => 'Controller:action',
            '_cacheLifetime' => 3600,
        ];

        $provider = new ProductRouteDefaultsProvider(
            $messageBus->reveal(),
            $factory->reveal(),
            $cacheLifetimeResolver->reveal(),
            $routeDefaultsFallback
        );

        $this->assertTrue($provider->supports(RoutableResource::class));
    }

    public function testNoSupports(): void
    {
        $messageBus = $this->prophesize(MessageBusInterface::class);
        $factory = $this->prophesize(StructureMetadataFactoryInterface::class);
        $cacheLifetimeResolver = $this->prophesize(CacheLifetimeResolverInterface::class);
        $routeDefaultsFallback = [
            'view' => 'default/product/view.html.twig',
            '_controller' => 'Controller:action',
            '_cacheLifetime' => 3600,
        ];

        $provider = new ProductRouteDefaultsProvider(
            $messageBus->reveal(),
            $factory->reveal(),
            $cacheLifetimeResolver->reveal(),
            $routeDefaultsFallback
        );

        $this->assertFalse($provider->supports(\stdClass::class));
    }
}
