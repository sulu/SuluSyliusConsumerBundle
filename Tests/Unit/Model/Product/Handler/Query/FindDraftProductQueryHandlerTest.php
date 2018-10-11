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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductDataNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Query\FindDraftProductQueryHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindDraftProductQuery;

class FindDraftProductQueryHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $productRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new FindDraftProductQueryHandler($productRepository->reveal(), $dimensionRepository->reveal());

        $message = $this->prophesize(FindDraftProductQuery::class);
        $message->getCode()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($dimension->reveal());

        $product = $this->prophesize(ProductDataInterface::class);
        $productRepository->findByCode('product-1', $dimension->reveal())
            ->willReturn($product->reveal())
            ->shouldBeCalled();

        $result = $handler->__invoke($message->reveal());
        $this->assertEquals($product->reveal(), $result);
    }

    public function testInvokeProductNotFound(): void
    {
        $this->expectException(ProductDataNotFoundException::class);

        $productRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new FindDraftProductQueryHandler($productRepository->reveal(), $dimensionRepository->reveal());

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($dimension->reveal());

        $message = $this->prophesize(FindDraftProductQuery::class);
        $message->getCode()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $productRepository->findByCode('product-1', $dimension->reveal())->willReturn(null);

        $handler->__invoke($message->reveal());
    }
}
