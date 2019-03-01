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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Query\FindProductQueryHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductQuery;

class FindProductQueryHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new FindProductQueryHandler($productInformationRepository->reveal(), $dimensionRepository->reveal());

        $message = $this->prophesize(FindProductQuery::class);
        $message->getId()->willReturn('123-123-123');
        $message->getLocale()->willReturn('en');

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($dimension->reveal());

        $product = $this->prophesize(ProductInformationInterface::class);
        $productInformationRepository->findByProductId('123-123-123', $dimension->reveal())
            ->willReturn($product->reveal())
            ->shouldBeCalled();

        $message->setProduct($product->reveal())->shouldBeCalled()->willReturn($message->reveal());
        $handler->__invoke($message->reveal());
    }

    public function testInvokeProductNotFound(): void
    {
        $this->expectException(ProductInformationNotFoundException::class);

        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new FindProductQueryHandler($productInformationRepository->reveal(), $dimensionRepository->reveal());

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($dimension->reveal());

        $message = $this->prophesize(FindProductQuery::class);
        $message->getId()->willReturn('123-123-123');
        $message->getLocale()->willReturn('en');

        $productInformationRepository->findByProductId('123-123-123', $dimension->reveal())->willReturn(null);

        $handler->__invoke($message->reveal());
    }
}
