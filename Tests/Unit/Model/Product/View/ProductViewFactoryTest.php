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
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\Routable;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\RoutableRepositoryInterface;

class ProductViewFactoryTest extends TestCase
{
    public function testCreate()
    {
        $contentRepository = $this->prophesize(ContentRepositoryInterface::class);
        $routableRepository = $this->prophesize(RoutableRepositoryInterface::class);

        $factory = new ProductViewFactory($contentRepository->reveal(), $routableRepository->reveal());

        $dimension = $this->prophesize(DimensionInterface::class);

        $product = $this->prophesize(ProductInterface::class);
        $product->getDimension()->willReturn($dimension->reveal());
        $product->getCode()->willReturn('product-1');
        $product->getVariants()->willReturn([]);

        $content = $this->prophesize(ContentInterface::class);
        $content->getData()->willReturn([]);
        $content->getType()->willReturn('default');
        $content->getDimension()->willReturn($dimension->reveal());
        $content->getResourceKey()->willReturn('products');
        $content->getResourceId()->willReturn('product-1');
        $contentRepository->findByDimensions('products', 'product-1', [$dimension->reveal()])
            ->willReturn([$content->reveal()]);

        $routable = $this->prophesize(Routable::class);
        $routableRepository->findOrCreateByResource('products', 'product-1', $dimension->reveal())
            ->willReturn($routable->reveal());

        $result = $factory->create([$product->reveal()], [$dimension->reveal()]);

        $this->assertEquals('product-1', $result->getCode());
        $this->assertEquals([], $result->getVariants());
        $this->assertEquals($routable->reveal(), $result->getRoutable());

        // FIXME change to assertEquals when content-view-factory was implemented
        $this->assertInstanceOf(ContentInterface::class, $result->getContent());
    }
}
