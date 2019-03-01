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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Content\Handler\Query;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Exception\ContentNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Handler\Query\FindContentQueryHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Query\FindContentQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;

class FindContentQueryHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $contentViewFactory = $this->prophesize(ContentViewFactoryInterface::class);

        $handler = new FindContentQueryHandler(
            $dimensionRepository->reveal(),
            $contentViewFactory->reveal()
        );

        $message = $this->prophesize(FindContentQuery::class);
        $message->getResourceId()->willReturn('product-1');
        $message->getResourceKey()->willReturn(ProductInterface::CONTENT_RESOURCE_KEY);
        $message->getLocale()->willReturn('de');

        $draftDimension = $this->prophesize(DimensionInterface::class);
        $localizedDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($draftDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($localizedDimension->reveal());

        $contentView = $this->prophesize(ContentViewInterface::class);
        $contentViewFactory->loadAndCreate(
            ProductInterface::CONTENT_RESOURCE_KEY,
            'product-1',
            [$draftDimension->reveal(), $localizedDimension->reveal()]
        )->willReturn($contentView->reveal());

        $message->setContent($contentView->reveal())->shouldBeCalled()->willReturn($message->reveal());
        $handler->__invoke($message->reveal());
    }

    public function testInvokeContentNotFound(): void
    {
        $this->expectException(ContentNotFoundException::class);

        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $contentViewFactory = $this->prophesize(ContentViewFactoryInterface::class);

        $handler = new FindContentQueryHandler(
            $dimensionRepository->reveal(),
            $contentViewFactory->reveal()
        );

        $message = $this->prophesize(FindContentQuery::class);
        $message->getResourceId()->willReturn('product-1');
        $message->getResourceKey()->willReturn(ProductInterface::CONTENT_RESOURCE_KEY);
        $message->getLocale()->willReturn('de');

        $draftDimension = $this->prophesize(DimensionInterface::class);
        $localizedDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($draftDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($localizedDimension->reveal());

        $contentViewFactory->loadAndCreate(
            ProductInterface::CONTENT_RESOURCE_KEY,
            'product-1',
            [$draftDimension->reveal(), $localizedDimension->reveal()]
        )->willReturn(null);

        $handler->__invoke($message->reveal());
    }
}
