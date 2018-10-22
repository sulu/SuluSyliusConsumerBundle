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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product\Handler\Message;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message\PublishContentMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Message\PublishProductMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\PublishProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\Message\PublishRoutableResourceMessage;
use Symfony\Cmf\Api\Slugifier\SlugifierInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class PublishProductMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $message = $this->prophesize(PublishProductMessage::class);
        $message->getId()->willReturn('123-123-123');
        $message->getLocale()->willReturn('en');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $messageBus = $this->prophesize(MessageBusInterface::class);
        $slugifier = $this->prophesize(SlugifierInterface::class);

        $handler = new PublishProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal(),
            $dimensionRepository->reveal(),
            $messageBus->reveal(),
            $slugifier->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $product->getCode()->willReturn('product-1');
        $product->getVariants()->willReturn([]);
        $productRepository->findById('123-123-123')->willReturn($product->reveal());

        $slugifier->slugify('product-1')->willReturn('product-1')->shouldBeCalled();

        $messageBus->dispatch(
            Argument::that(
                function ($message) {
                    return $message instanceof PublishContentMessage
                        && '123-123-123' === $message->getResourceId()
                        && ProductInterface::RESOURCE_KEY === $message->getResourceKey()
                        && 'en' === $message->getLocale();
                }
            )
        )->shouldBeCalled();

        $messageBus->dispatch(
            Argument::that(
                function ($message) {
                    return $message instanceof PublishRoutableResourceMessage
                        && '123-123-123' === $message->getResourceId()
                        && ProductInterface::RESOURCE_KEY === $message->getResourceKey()
                        && 'en' === $message->getLocale()
                        && '/products/product-1' === $message->getRoutePath();
                }
            )
        )->shouldBeCalled();

        $liveDimension = $this->prophesize(DimensionInterface::class);
        $draftDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($draftDimension->reveal());

        $liveProductInformation = $this->prophesize(ProductInformationInterface::class);
        $draftProductInformation = $this->prophesize(ProductInformationInterface::class);

        $productInformationRepository->findByProductId('123-123-123', $liveDimension->reveal())
            ->willReturn($liveProductInformation->reveal())
            ->shouldBeCalled();
        $productInformationRepository->findByProductId('123-123-123', $draftDimension->reveal())
            ->willReturn($draftProductInformation->reveal())
            ->shouldBeCalled();

        $liveProductInformation->mapPublishProperties($draftProductInformation->reveal())->shouldBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeCreateLiveProduct(): void
    {
        $message = $this->prophesize(PublishProductMessage::class);
        $message->getId()->willReturn('123-123-123');
        $message->getLocale()->willReturn('en');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $messageBus = $this->prophesize(MessageBusInterface::class);
        $slugifier = $this->prophesize(SlugifierInterface::class);

        $handler = new PublishProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal(),
            $dimensionRepository->reveal(),
            $messageBus->reveal(),
            $slugifier->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $product->getCode()->willReturn('product-1');
        $product->getVariants()->willReturn([]);
        $productRepository->findById('123-123-123')->willReturn($product->reveal());

        $slugifier->slugify('product-1')->willReturn('product-1')->shouldBeCalled();

        $messageBus->dispatch(
            Argument::that(
                function ($message) {
                    return $message instanceof PublishContentMessage
                        && '123-123-123' === $message->getResourceId()
                        && ProductInterface::RESOURCE_KEY === $message->getResourceKey()
                        && 'en' === $message->getLocale();
                }
            )
        )->shouldBeCalled();

        $messageBus->dispatch(
            Argument::that(
                function ($message) {
                    return $message instanceof PublishRoutableResourceMessage
                        && '123-123-123' === $message->getResourceId()
                        && ProductInterface::RESOURCE_KEY === $message->getResourceKey()
                        && 'en' === $message->getLocale()
                        && '/products/product-1' === $message->getRoutePath();
                }
            )
        )->shouldBeCalled();

        $liveDimension = $this->prophesize(DimensionInterface::class);
        $draftDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
             DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en', ]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
             DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en', ]
        )->willReturn($draftDimension->reveal());

        $liveProductInformation = $this->prophesize(ProductInformationInterface::class);
        $draftProductInformation = $this->prophesize(ProductInformationInterface::class);

        $draftProductInformation->getName()->willReturn('Product One');

        $productInformationRepository->findByProductId('123-123-123', $liveDimension->reveal())->willReturn(null)->shouldBeCalled();
        $productInformationRepository->findByProductId('123-123-123', $draftDimension->reveal())
            ->willReturn($draftProductInformation->reveal())
            ->shouldBeCalled();

        $productInformationRepository->create($product->reveal(), $liveDimension->reveal())
            ->willReturn($liveProductInformation->reveal())
            ->shouldBeCalled();

        $liveProductInformation->mapPublishProperties($draftProductInformation->reveal())->shouldBeCalled();

        $handler->__invoke($message->reveal());
    }
}
