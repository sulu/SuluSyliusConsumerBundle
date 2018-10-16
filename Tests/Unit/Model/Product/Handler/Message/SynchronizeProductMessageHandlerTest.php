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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationVariantRepositoryInterface;
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
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductInformationVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $productRepository->findByCode('product-1')->willReturn(null)->shouldBeCalled();
        $productRepository->create('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($dimension->reveal());

        $productInformationRepository->findById('123-123-123', $dimension->reveal())->willReturn(null);
        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productInformation->getVariants()->willReturn([]);
        $productInformation->setName('Product One')->shouldBeCalled()->willReturn($productInformation->reveal());
        $productInformationRepository->create($product->reveal(), $dimension->reveal())
            ->shouldBeCalled()
            ->willReturn($productInformation->reveal());

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
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductInformationVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $productRepository->findByCode('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($dimension->reveal());

        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productInformation->getVariants()->willReturn([]);
        $productInformation->setName('Product One')->shouldBeCalled()->willReturn($productInformation->reveal());
        $productInformationRepository->findById('123-123-123', $dimension->reveal())
            ->willReturn($productInformation->reveal());
        $productInformationRepository->create(Argument::cetera())->shouldNotBeCalled();

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
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductInformationVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $productRepository->findByCode('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($dimension->reveal());

        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productInformation->getVariants()->willReturn([]);
        $productInformation->findVariantByCode('variant-1')->willReturn(null);
        $productInformation->setName('Product One')->willReturn($productInformation->reveal())->shouldBeCalled();
        $productInformationRepository->findById('123-123-123', $dimension->reveal())
            ->willReturn($productInformation->reveal());
        $productInformationRepository->create(Argument::cetera())->shouldNotBeCalled();

        $variant = $this->prophesize(ProductInformationVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');
        $variant->setName('Variant One')->willReturn($variant->reveal())->shouldBeCalled();
        $variantRepository->create($productInformation->reveal(), 'variant-1')
            ->shouldBeCalled()
            ->willReturn($variant->reveal());

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
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductInformationVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $productRepository->findByCode('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($dimension->reveal());

        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productInformationRepository->findById('123-123-123', $dimension->reveal())
            ->willReturn($productInformation->reveal());
        $productInformationRepository->create(Argument::cetera())->shouldNotBeCalled();

        $variant = $this->prophesize(ProductInformationVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');
        $productInformation->getVariants()->willReturn([$variant->reveal()]);
        $productInformation->setName('Product One')->willReturn($productInformation->reveal())->shouldBeCalled();

        $productInformation->removeVariant($variant->reveal())
            ->shouldBeCalled()
            ->willReturn($productInformation->reveal());

        $handler->__invoke($message->reveal());
    }
}
