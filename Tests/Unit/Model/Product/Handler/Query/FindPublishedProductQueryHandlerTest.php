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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Query\FindPublishedProductQueryHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindPublishedProductQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactoryInterface;

class FindPublishedProductQueryHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $productRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $productViewFactory = $this->prophesize(ProductViewFactoryInterface::class);

        $handler = new FindPublishedProductQueryHandler(
            $productRepository->reveal(),
            $dimensionRepository->reveal(),
            $productViewFactory->reveal()
        );

        $message = $this->prophesize(FindPublishedProductQuery::class);
        $message->getId()->willReturn('123-123-123');
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

        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productRepository->findById('123-123-123', $localizedDimension->reveal())
            ->willReturn($productInformation->reveal())
            ->shouldBeCalled();

        $productView = $this->prophesize(ProductViewInterface::class);
        $productViewFactory->create($productInformation->reveal(), [$dimension->reveal(), $localizedDimension->reveal()])
            ->shouldBeCalled()
            ->willReturn($productView->reveal());

        $result = $handler->__invoke($message->reveal());
        $this->assertEquals($productView->reveal(), $result);
    }

    public function testInvokeProductNotFound(): void
    {
        $this->expectException(ProductInformationNotFoundException::class);

        $productRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $productViewFactory = $this->prophesize(ProductViewFactoryInterface::class);

        $handler = new FindPublishedProductQueryHandler(
            $productRepository->reveal(),
            $dimensionRepository->reveal(),
            $productViewFactory->reveal()
        );

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE]
        )->willReturn($dimension->reveal());

        $localizedDimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE, 'locale' => 'en']
        )->willReturn($localizedDimension->reveal());

        $message = $this->prophesize(FindPublishedProductQuery::class);
        $message->getId()->willReturn('123-123-123');
        $message->getLocale()->willReturn('en');

        $productRepository->findById('123-123-123', $localizedDimension->reveal())->willReturn(null);

        $handler->__invoke($message->reveal());
    }
}
