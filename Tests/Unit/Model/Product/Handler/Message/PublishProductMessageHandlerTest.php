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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\Message\PublishRoutableResourceMessage;
use Symfony\Cmf\Api\Slugifier\SlugifierInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class PublishProductMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $message = $this->prophesize(PublishProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $messageBus = $this->prophesize(MessageBusInterface::class);
        $slugifier = $this->prophesize(SlugifierInterface::class);

        $handler = new PublishProductMessageHandler(
            $productRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal(),
            $messageBus->reveal(),
            $slugifier->reveal()
        );

        $slugifier->slugify('product-1')->willReturn('product-1')->shouldBeCalled();

        $messageBus->dispatch(
            Argument::that(
                function ($message) {
                    return $message instanceof PublishContentMessage
                        && 'product-1' === $message->getResourceId()
                        && ProductInterface::RESOURCE_KEY === $message->getResourceKey()
                        && 'en' === $message->getLocale();
                }
            )
        )->shouldBeCalled();

        $messageBus->dispatch(
            Argument::that(
                function ($message) {
                    return $message instanceof PublishRoutableResourceMessage
                        && 'product-1' === $message->getResourceId()
                        && ProductInterface::RESOURCE_KEY === $message->getResourceKey()
                        && 'en' === $message->getLocale()
                        && '/products/product-1' === $message->getRoutePath();
                }
            )
        )->shouldBeCalled();

        $liveDimension = $this->prophesize(DimensionInterface::class);
        $draftDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($draftDimension->reveal());

        $liveProduct = $this->prophesize(ProductInterface::class);
        $draftProduct = $this->prophesize(ProductInterface::class);

        $draftProduct->getVariants()->willReturn([]);

        $productRepository->findByCode($liveDimension->reveal(), 'product-1')
            ->willReturn($liveProduct->reveal())
            ->shouldBeCalled();
        $productRepository->findByCode($draftDimension->reveal(), 'product-1')
            ->willReturn($draftProduct->reveal())
            ->shouldBeCalled();

        $liveProduct->getVariants()->willReturn([]);

        $handler->__invoke($message->reveal());
    }

    public function testInvokeAddVariantCreateVariant(): void
    {
        $message = $this->prophesize(PublishProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $messageBus = $this->prophesize(MessageBusInterface::class);
        $slugifier = $this->prophesize(SlugifierInterface::class);

        $handler = new PublishProductMessageHandler(
            $productRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal(),
            $messageBus->reveal(),
            $slugifier->reveal()
        );

        $slugifier->slugify('product-1')->willReturn('product-1')->shouldBeCalled();

        $messageBus->dispatch(Argument::any())->shouldBeCalledTimes(2);

        $liveDimension = $this->prophesize(DimensionInterface::class);
        $draftDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($draftDimension->reveal());

        $liveProduct = $this->prophesize(ProductInterface::class);
        $draftProduct = $this->prophesize(ProductInterface::class);

        $variant = $this->prophesize(ProductVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');
        $draftProduct->getVariants()->willReturn([$variant->reveal()]);

        $productRepository->findByCode($liveDimension->reveal(), 'product-1')
            ->willReturn($liveProduct->reveal())
            ->shouldBeCalled();
        $productRepository->findByCode($draftDimension->reveal(), 'product-1')
            ->willReturn($draftProduct->reveal())
            ->shouldBeCalled();

        $liveProduct->findVariantByCode('variant-1')->willReturn(null);
        $liveVariant = $this->prophesize(ProductVariantInterface::class);
        $liveVariant->getCode()->willReturn('variant-1');
        $variantRepository->create($liveProduct->reveal(), 'variant-1')->shouldBeCalled()
            ->willReturn($liveVariant->reveal());

        $liveProduct->getVariants()->willReturn([$liveVariant->reveal()]);

        $handler->__invoke($message->reveal());
    }

    public function testInvokeAddVariantRemoveVariant(): void
    {
        $message = $this->prophesize(PublishProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $messageBus = $this->prophesize(MessageBusInterface::class);
        $slugifier = $this->prophesize(SlugifierInterface::class);

        $handler = new PublishProductMessageHandler(
            $productRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal(),
            $messageBus->reveal(),
            $slugifier->reveal()
        );

        $slugifier->slugify('product-1')->willReturn('product-1')->shouldBeCalled();

        $messageBus->dispatch(Argument::any())->shouldBeCalledTimes(2);

        $liveDimension = $this->prophesize(DimensionInterface::class);
        $draftDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($draftDimension->reveal());

        $liveProduct = $this->prophesize(ProductInterface::class);
        $draftProduct = $this->prophesize(ProductInterface::class);

        $draftProduct->getVariants()->willReturn([]);

        $productRepository->findByCode($liveDimension->reveal(), 'product-1')
            ->willReturn($liveProduct->reveal())
            ->shouldBeCalled();
        $productRepository->findByCode($draftDimension->reveal(), 'product-1')
            ->willReturn($draftProduct->reveal())
            ->shouldBeCalled();

        $liveVariant = $this->prophesize(ProductVariantInterface::class);
        $liveVariant->getCode()->willReturn('variant-1');

        $variantRepository->create($liveProduct->reveal(), 'variant-1')->shouldNotBeCalled();

        $liveProduct->getVariants()->willReturn([$liveVariant->reveal()]);
        $liveProduct->removeVariant($liveVariant->reveal())->willReturn($liveProduct->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeAddVariantDoNothing(): void
    {
        $message = $this->prophesize(PublishProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $messageBus = $this->prophesize(MessageBusInterface::class);
        $slugifier = $this->prophesize(SlugifierInterface::class);

        $handler = new PublishProductMessageHandler(
            $productRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal(),
            $messageBus->reveal(),
            $slugifier->reveal()
        );

        $slugifier->slugify('product-1')->willReturn('product-1')->shouldBeCalled();

        $messageBus->dispatch(Argument::any())->shouldBeCalledTimes(2);

        $liveDimension = $this->prophesize(DimensionInterface::class);
        $draftDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($draftDimension->reveal());

        $liveProduct = $this->prophesize(ProductInterface::class);
        $draftProduct = $this->prophesize(ProductInterface::class);

        $productRepository->findByCode($liveDimension->reveal(), 'product-1')
            ->willReturn($liveProduct->reveal())
            ->shouldBeCalled();
        $productRepository->findByCode($draftDimension->reveal(), 'product-1')
            ->willReturn($draftProduct->reveal())
            ->shouldBeCalled();

        $draftVariant = $this->prophesize(ProductVariantInterface::class);
        $draftVariant->getCode()->willReturn('variant-1');

        $draftProduct->getVariants()->willReturn([$draftVariant->reveal()]);

        $liveVariant = $this->prophesize(ProductVariantInterface::class);
        $liveVariant->getCode()->willReturn('variant-1');

        $variantRepository->create($liveProduct->reveal(), 'variant-1')->shouldNotBeCalled();

        $liveProduct->findVariantByCode('variant-1')->willReturn($liveVariant->reveal());
        $liveProduct->getVariants()->willReturn([$liveVariant->reveal()]);
        $liveProduct->removeVariant(Argument::any())->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeCreateLiveProduct(): void
    {
        $message = $this->prophesize(PublishProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $messageBus = $this->prophesize(MessageBusInterface::class);
        $slugifier = $this->prophesize(SlugifierInterface::class);

        $handler = new PublishProductMessageHandler(
            $productRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal(),
            $messageBus->reveal(),
            $slugifier->reveal()
        );

        $slugifier->slugify('product-1')->willReturn('product-1')->shouldBeCalled();

        $messageBus->dispatch(
            Argument::that(
                function ($message) {
                    return $message instanceof PublishContentMessage
                        && 'product-1' === $message->getResourceId()
                        && 'products' === $message->getResourceKey()
                        && 'en' === $message->getLocale();
                }
            )
        )->shouldBeCalled();

        $messageBus->dispatch(
            Argument::that(
                function ($message) {
                    return $message instanceof PublishRoutableResourceMessage
                        && 'product-1' === $message->getResourceId()
                        && 'products' === $message->getResourceKey()
                        && 'en' === $message->getLocale()
                        && '/products/product-1' === $message->getRoutePath();
                }
            )
        )->shouldBeCalled();

        $liveDimension = $this->prophesize(DimensionInterface::class);
        $draftDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($draftDimension->reveal());

        $liveProduct = $this->prophesize(ProductInterface::class);
        $draftProduct = $this->prophesize(ProductInterface::class);

        $liveProduct->getVariants()->willReturn([]);
        $draftProduct->getVariants()->willReturn([]);

        $productRepository->findByCode($liveDimension->reveal(), 'product-1')->willReturn(null)->shouldBeCalled();
        $productRepository->findByCode($draftDimension->reveal(), 'product-1')
            ->willReturn($draftProduct->reveal())
            ->shouldBeCalled();

        $productRepository->create($liveDimension->reveal(), 'product-1')
            ->willReturn($liveProduct->reveal())
            ->shouldBeCalled();

        $handler->__invoke($message->reveal());
    }
}
