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
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Message\SynchronizeProductMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductTranslationValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductVariantTranslationValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductVariantValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataVariantRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class SynchronizeProductMessageHandlerTest extends TestCase
{
    public function testInvokeCreate(): void
    {
        $productTranslationValueObject = $this->prophesize(ProductTranslationValueObject::class);
        $productTranslationValueObject->getLocale()->willReturn('de');
        $productTranslationValueObject->getName()->willReturn('Product One');

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getVariants()->willReturn([]);
        $message->getTranslations()->willReturn([$productTranslationValueObject->reveal()]);

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productDataRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductDataVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $productDataRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $productRepository->create('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($dimension->reveal());

        $productDataRepository->findByCode('product-1', $dimension->reveal())->willReturn(null);
        $productData = $this->prophesize(ProductDataInterface::class);
        $productData->getVariants()->willReturn([]);
        $productData->setName('Product One')->shouldBeCalled()->willReturn($productData->reveal());
        $productDataRepository->create('product-1', $dimension->reveal())
            ->shouldBeCalled()
            ->willReturn($productData->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeUpdate(): void
    {
        $productTranslationValueObject = $this->prophesize(ProductTranslationValueObject::class);
        $productTranslationValueObject->getLocale()->willReturn('de');
        $productTranslationValueObject->getName()->willReturn('Product One');

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getVariants()->willReturn([]);
        $message->getTranslations()->willReturn([$productTranslationValueObject->reveal()]);

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productDataRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductDataVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $productDataRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $productRepository->create('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($dimension->reveal());

        $productData = $this->prophesize(ProductDataInterface::class);
        $productData->getVariants()->willReturn([]);
        $productData->setName('Product One')->shouldBeCalled()->willReturn($productData->reveal());
        $productDataRepository->findByCode('product-1', $dimension->reveal())->willReturn($productData->reveal());
        $productDataRepository->create(Argument::cetera())->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeCreateVariant(): void
    {
        $variantTranslationValueObject = $this->prophesize(ProductVariantTranslationValueObject::class);
        $variantTranslationValueObject->getLocale()->willReturn('en');
        $variantTranslationValueObject->getName()->willReturn('Variant One');

        $variantValueObject = $this->prophesize(ProductVariantValueObject::class);
        $variantValueObject->getCode()->willReturn('variant-1');
        $variantValueObject->findTranslationByLocale('en')->willReturn($variantTranslationValueObject->reveal());

        $productTranslationValueObject = $this->prophesize(ProductTranslationValueObject::class);
        $productTranslationValueObject->getLocale()->willReturn('en');
        $productTranslationValueObject->getName()->willReturn('Product One');

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getTranslations()->willReturn([$productTranslationValueObject->reveal()]);
        $message->getVariants()->willReturn(
            [
                $variantValueObject->reveal(),
            ]
        );

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productDataRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductDataVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $productDataRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $productRepository->create('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($dimension->reveal());

        $productData = $this->prophesize(ProductDataInterface::class);
        $productData->getVariants()->willReturn([]);
        $productData->findVariantByCode('variant-1')->willReturn(null);
        $productData->setName('Product One')->willReturn($productData->reveal())->shouldBeCalled();
        $productDataRepository->findByCode('product-1', $dimension->reveal())->willReturn($productData->reveal());
        $productDataRepository->create(Argument::cetera())->shouldNotBeCalled();

        $variant = $this->prophesize(ProductDataVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');
        $variant->setName('Variant One')->willReturn($variant->reveal())->shouldBeCalled();
        $variantRepository->create($productData->reveal(), 'variant-1')->shouldBeCalled()->willReturn($variant->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeRemoveVariant(): void
    {
        $productTranslationValueObject = $this->prophesize(ProductTranslationValueObject::class);
        $productTranslationValueObject->getLocale()->willReturn('en');
        $productTranslationValueObject->getName()->willReturn('Product One');

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getVariants()->willReturn([]);
        $message->getTranslations()->willReturn([$productTranslationValueObject->reveal()]);

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productDataRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductDataVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $productDataRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $productRepository->create('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($dimension->reveal());

        $productData = $this->prophesize(ProductDataInterface::class);
        $productDataRepository->findByCode('product-1', $dimension->reveal())->willReturn($productData->reveal());
        $productDataRepository->create(Argument::cetera())->shouldNotBeCalled();

        $variant = $this->prophesize(ProductDataVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');
        $productData->getVariants()->willReturn([$variant->reveal()]);
        $productData->setName('Product One')->willReturn($productData->reveal())->shouldBeCalled();

        $productData->removeVariant($variant->reveal())->shouldBeCalled()->willReturn($productData->reveal());

        $handler->__invoke($message->reveal());
    }
}
