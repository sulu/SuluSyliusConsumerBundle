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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class SynchronizeProductMessageHandlerTest extends TestCase
{
    public function testInvokeCreate(): void
    {
        $productTranslationValueObject = $this->prophesize(ProductTranslationValueObject::class);
        $productTranslationValueObject->getLocale()->willReturn('de');
        $productTranslationValueObject->getName()->willReturn('Product One');
        $productTranslationValueObject->getSlug()->willReturn('/nice-slug');
        $productTranslationValueObject->getDescription()->willReturn('Very nice description! Yes!');
        $productTranslationValueObject->getShortDescription()->willReturn('Nice, but short!');
        $productTranslationValueObject->getMetaKeywords()->willReturn('123, 123, 123');
        $productTranslationValueObject->getMetaDescription()->willReturn('Meta description..');

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getTranslations()->willReturn([$productTranslationValueObject->reveal()]);

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $productRepository->findByCode('product-1')->willReturn(null)->shouldBeCalled();
        $productRepository->create('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $dimensionDraft = $this->prophesize(DimensionInterface::class);
        $dimensionLive = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($dimensionDraft->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($dimensionLive->reveal());

        $productInformationRepository->findByProductId('123-123-123', $dimensionDraft->reveal())->willReturn(null);
        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productInformation->setName('Product One')->shouldBeCalled()->willReturn($productInformation->reveal());
        $productInformation->setSlug('/nice-slug')->shouldBeCalled()->willReturn($productInformation->reveal());
        $productInformation->setDescription('Very nice description! Yes!')->shouldBeCalled()->willReturn($productInformation->reveal());
        $productInformation->setMetaKeywords('123, 123, 123')->shouldBeCalled()->willReturn($productInformation->reveal());
        $productInformation->setMetaDescription('Meta description..')->shouldBeCalled()->willReturn($productInformation->reveal());
        $productInformation->setShortDescription('Nice, but short!')->shouldBeCalled()->willReturn($productInformation->reveal());
        $productInformationRepository->create($product->reveal(), $dimensionDraft->reveal())
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
        $message->getSlug()->willReturn('/nice-slug');
        $message->getTranslations()->willReturn([$productTranslationValueObject->reveal()]);

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal(),
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
        $productInformation->setName('Product One')->shouldBeCalled()->willReturn($productInformation->reveal());
        $productInformationRepository->findByProductId('123-123-123', $dimension->reveal())
            ->willReturn($productInformation->reveal());
        $productInformationRepository->create(Argument::cetera())->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }
}
