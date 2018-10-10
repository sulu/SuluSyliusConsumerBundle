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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductVariantValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;

class SynchronizeProductMessageHandlerTest extends TestCase
{
    public function testInvokeCreate(): void
    {
        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getVariants()->willReturn([]);

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($dimension->reveal());

        $productRepository->findByCode('product-1', $dimension->reveal())->willReturn(null);
        $product = $this->prophesize(ProductInterface::class);
        $product->getVariants()->willReturn([]);
        $productRepository->create('product-1', $dimension->reveal())->shouldBeCalled()->willReturn($product->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeUpdate(): void
    {
        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getVariants()->willReturn([]);

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($dimension->reveal());

        $product = $this->prophesize(ProductInterface::class);
        $product->getVariants()->willReturn([]);
        $productRepository->findByCode('product-1', $dimension->reveal())->willReturn($product->reveal());
        $productRepository->create(Argument::cetera())->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeCreateVariant(): void
    {
        $variantDTO = $this->prophesize(ProductVariantValueObject::class);
        $variantDTO->getCode()->willReturn('variant-1');

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getVariants()->willReturn(
            [
                $variantDTO->reveal(),
            ]
        );

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($dimension->reveal());

        $product = $this->prophesize(ProductInterface::class);
        $product->getVariants()->willReturn([]);
        $product->findVariantByCode('variant-1')->willReturn(null);
        $productRepository->findByCode('product-1', $dimension->reveal())->willReturn($product->reveal());
        $productRepository->create(Argument::cetera())->shouldNotBeCalled();

        $variant = $this->prophesize(ProductVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');
        $variantRepository->create($product->reveal(), 'variant-1')->shouldBeCalled()->willReturn($variant->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeRemoveVariant(): void
    {
        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getVariants()->willReturn([]);

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);

        $handler = new SynchronizeProductMessageHandler(
            $productRepository->reveal(),
            $variantRepository->reveal(),
            $dimensionRepository->reveal()
        );

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($dimension->reveal());

        $product = $this->prophesize(ProductInterface::class);
        $productRepository->findByCode('product-1', $dimension->reveal())->willReturn($product->reveal());
        $productRepository->create(Argument::cetera())->shouldNotBeCalled();

        $variant = $this->prophesize(ProductVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');
        $product->getVariants()->willReturn([$variant->reveal()]);

        $product->removeVariant($variant->reveal())->shouldBeCalled()->willReturn($product->reveal());

        $handler->__invoke($message->reveal());
    }
}
