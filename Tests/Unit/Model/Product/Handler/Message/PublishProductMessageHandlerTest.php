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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataVariantRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
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

        $productRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductDataVariantRepositoryInterface::class);
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

        $liveProduct = $this->prophesize(ProductDataInterface::class);
        $draftProduct = $this->prophesize(ProductDataInterface::class);

        $draftProduct->getVariants()->willReturn([]);
        $draftProduct->getName()->willReturn('Product One');

        $productRepository->findByCode('product-1', $liveDimension->reveal())
            ->willReturn($liveProduct->reveal())
            ->shouldBeCalled();
        $productRepository->findByCode('product-1', $draftDimension->reveal())
            ->willReturn($draftProduct->reveal())
            ->shouldBeCalled();

        $liveProduct->getVariants()->willReturn([]);
        $liveProduct->setName('Product One')->shouldBeCalled()->willReturn($liveProduct->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeAddVariantCreateVariant(): void
    {
        $message = $this->prophesize(PublishProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $productRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductDataVariantRepositoryInterface::class);
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
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
            DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en', ]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
             DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en', ]
        )->willReturn($draftDimension->reveal());

        $liveProduct = $this->prophesize(ProductDataInterface::class);
        $draftProduct = $this->prophesize(ProductDataInterface::class);
        $draftProduct->getName()->willReturn('Product One');

        $variant = $this->prophesize(ProductDataVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');
        $variant->getName()->willReturn('Product Variant One');
        $draftProduct->getVariants()->willReturn([$variant->reveal()]);

        $productRepository->findByCode('product-1', $liveDimension->reveal())
            ->willReturn($liveProduct->reveal())
            ->shouldBeCalled();
        $productRepository->findByCode('product-1', $draftDimension->reveal())
            ->willReturn($draftProduct->reveal())
            ->shouldBeCalled();

        $liveProduct->findVariantByCode('variant-1')->willReturn(null);
        $liveVariant = $this->prophesize(ProductDataVariantInterface::class);
        $liveVariant->getCode()->willReturn('variant-1');
        $liveVariant->setName('Product Variant One')->shouldBeCalled($liveVariant->reveal());
        $variantRepository->create($liveProduct->reveal(), 'variant-1')->shouldBeCalled()
            ->willReturn($liveVariant->reveal());

        $liveProduct->getVariants()->willReturn([$liveVariant->reveal()]);
        $liveProduct->setName('Product One')->shouldBeCalled()->willReturn($liveProduct->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeAddVariantRemoveVariant(): void
    {
        $message = $this->prophesize(PublishProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $productRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductDataVariantRepositoryInterface::class);
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
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
             DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en', ]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
             DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en', ]
        )->willReturn($draftDimension->reveal());

        $liveProduct = $this->prophesize(ProductDataInterface::class);
        $draftProduct = $this->prophesize(ProductDataInterface::class);
        $draftProduct->getName()->willReturn('Product One');

        $draftProduct->getVariants()->willReturn([]);

        $productRepository->findByCode('product-1', $liveDimension->reveal())
            ->willReturn($liveProduct->reveal())
            ->shouldBeCalled();
        $productRepository->findByCode('product-1', $draftDimension->reveal())
            ->willReturn($draftProduct->reveal())
            ->shouldBeCalled();

        $liveVariant = $this->prophesize(ProductDataVariantInterface::class);
        $liveVariant->getCode()->willReturn('variant-1');

        $variantRepository->create($liveProduct->reveal(), 'variant-1')->shouldNotBeCalled();

        $liveProduct->setName('Product One')->shouldBeCalled()->willReturn($liveProduct->reveal());
        $liveProduct->getVariants()->willReturn([$liveVariant->reveal()]);
        $liveProduct->removeVariant($liveVariant->reveal())->willReturn($liveProduct->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeAddVariantDoNothing(): void
    {
        $message = $this->prophesize(PublishProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $productRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductDataVariantRepositoryInterface::class);
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
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
             DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en', ]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
                        [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
             DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en', ]
        )->willReturn($draftDimension->reveal());

        $liveProduct = $this->prophesize(ProductDataInterface::class);
        $draftProduct = $this->prophesize(ProductDataInterface::class);

        $productRepository->findByCode('product-1', $liveDimension->reveal())
            ->willReturn($liveProduct->reveal())
            ->shouldBeCalled();
        $productRepository->findByCode('product-1', $draftDimension->reveal())
            ->willReturn($draftProduct->reveal())
            ->shouldBeCalled();

        $draftVariant = $this->prophesize(ProductDataVariantInterface::class);
        $draftVariant->getCode()->willReturn('variant-1');
        $draftVariant->getName()->willReturn('Product Variant One');

        $draftProduct->getVariants()->willReturn([$draftVariant->reveal()]);
        $draftProduct->getName()->willReturn('Product One');

        $liveVariant = $this->prophesize(ProductDataVariantInterface::class);
        $liveVariant->getCode()->willReturn('variant-1');
        $liveVariant->getName()->willReturn('Product Variant One');
        $liveVariant->setName('Product Variant One')->willReturn($liveVariant->reveal());

        $variantRepository->create($liveProduct->reveal(), 'variant-1')->shouldNotBeCalled();

        $liveProduct->setName('Product One')->shouldBeCalled()->willReturn($liveProduct->reveal());
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

        $productRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductDataVariantRepositoryInterface::class);
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
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
             DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en', ]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
             DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en', ]
        )->willReturn($draftDimension->reveal());

        $liveProduct = $this->prophesize(ProductDataInterface::class);
        $draftProduct = $this->prophesize(ProductDataInterface::class);

        $liveProduct->getVariants()->willReturn([]);
        $draftProduct->getVariants()->willReturn([]);
        $draftProduct->getName()->willReturn('Product One');

        $productRepository->findByCode('product-1', $liveDimension->reveal())->willReturn(null)->shouldBeCalled();
        $productRepository->findByCode('product-1', $draftDimension->reveal())
            ->willReturn($draftProduct->reveal())
            ->shouldBeCalled();

        $productRepository->create('product-1', $liveDimension->reveal())
            ->willReturn($liveProduct->reveal())
            ->shouldBeCalled();

        $liveProduct->setName('Product One')->shouldBeCalled()->willReturn($liveProduct->reveal());

        $handler->__invoke($message->reveal());
    }
}
