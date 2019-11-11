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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product\Handler\Query;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Query\FindProductViewsQueryHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductViewsQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactoryInterface;

class FindProductViewsQueryHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $productViewFactory = $this->prophesize(ProductViewFactoryInterface::class);

        $handler = new FindProductViewsQueryHandler(
            $dimensionRepository->reveal(),
            $productRepository->reveal(),
            $productViewFactory->reveal()
        );

        $message = $this->prophesize(FindProductViewsQuery::class);
        $message->getIds()->willReturn(['111-111-111', '222-222-222']);
        $message->getLocale()->willReturn('en');

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE]
        )->willReturn($dimension->reveal());

        $localizedDimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($localizedDimension->reveal());

        $product1 = $this->prophesize(ProductInterface::class);
        $product1->getId()->willReturn('111-111-111');
        $product2 = $this->prophesize(ProductInterface::class);
        $product2->getId()->willReturn('222-222-222');

        $productRepository->findByIdsAndDimensionIds(
            ['111-111-111', '222-222-222'],
            [$dimension->reveal(), $localizedDimension->reveal()]
        )
            ->willReturn([$product2->reveal(), $product1->reveal()])
            ->shouldBeCalled();

        $productView1 = $this->prophesize(ProductViewInterface::class);
        $productView2 = $this->prophesize(ProductViewInterface::class);

        $productViewFactory->create($product1->reveal(), [$dimension->reveal(), $localizedDimension->reveal()])
            ->shouldBeCalled()
            ->willReturn($productView1->reveal());

        $productViewFactory->create($product2->reveal(), [$dimension->reveal(), $localizedDimension->reveal()])
            ->shouldBeCalled()
            ->willReturn($productView2->reveal());

        $message->setProductViews([$productView1->reveal(), $productView2->reveal()])->shouldBeCalled()
            ->willReturn($message->reveal());

        $handler->__invoke($message->reveal());
    }
}
