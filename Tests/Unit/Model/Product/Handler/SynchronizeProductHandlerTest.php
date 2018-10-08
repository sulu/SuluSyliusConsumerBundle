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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product\Handler;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\SynchronizeProductHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductDTO;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ProductVariantDTO;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;

class SynchronizeProductHandlerTest extends TestCase
{
    public function testInvokeCreate(): void
    {
        $productDTO = $this->prophesize(ProductDTO::class);
        $productDTO->getCode()->willReturn('product-1');
        $productDTO->getVariants()->willReturn([]);

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getProduct()->willReturn($productDTO->reveal());

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $handler = new SynchronizeProductHandler($productRepository->reveal(), $variantRepository->reveal());

        $productRepository->findByCode('product-1')->willReturn(null);
        $product = $this->prophesize(ProductInterface::class);
        $product->getVariants()->willReturn([]);
        $productRepository->create('product-1')->shouldBeCalled()->willReturn($product->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeUpdate(): void
    {
        $productDTO = $this->prophesize(ProductDTO::class);
        $productDTO->getCode()->willReturn('product-1');
        $productDTO->getVariants()->willReturn([]);

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getProduct()->willReturn($productDTO->reveal());

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $handler = new SynchronizeProductHandler($productRepository->reveal(), $variantRepository->reveal());

        $product = $this->prophesize(ProductInterface::class);
        $product->getVariants()->willReturn([]);
        $productRepository->findByCode('product-1')->willReturn($product->reveal());
        $productRepository->create('product-1')->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeCreateVariant(): void
    {
        $variantDTO = $this->prophesize(ProductVariantDTO::class);
        $variantDTO->getCode()->willReturn('variant-1');

        $productDTO = $this->prophesize(ProductDTO::class);
        $productDTO->getCode()->willReturn('product-1');
        $productDTO->getVariants()->willReturn(
            [
                $variantDTO->reveal(),
            ]
        );

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getProduct()->willReturn($productDTO->reveal());

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $handler = new SynchronizeProductHandler($productRepository->reveal(), $variantRepository->reveal());

        $product = $this->prophesize(ProductInterface::class);
        $product->getVariants()->willReturn([]);
        $product->findVariantByCode('variant-1')->willReturn(null);
        $productRepository->findByCode('product-1')->willReturn($product->reveal());
        $productRepository->create('product-1')->shouldNotBeCalled();

        $variant = $this->prophesize(ProductVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');
        $variantRepository->create($product->reveal(), 'variant-1')->shouldBeCalled()->willReturn($variant->reveal());

        $handler->__invoke($message->reveal());
    }

    public function testInvokeRemoveVariant(): void
    {
        $productDTO = $this->prophesize(ProductDTO::class);
        $productDTO->getCode()->willReturn('product-1');
        $productDTO->getVariants()->willReturn([]);

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getProduct()->willReturn($productDTO->reveal());

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $variantRepository = $this->prophesize(ProductVariantRepositoryInterface::class);
        $handler = new SynchronizeProductHandler($productRepository->reveal(), $variantRepository->reveal());

        $product = $this->prophesize(ProductInterface::class);
        $productRepository->findByCode('product-1')->willReturn($product->reveal());
        $productRepository->create('product-1')->shouldNotBeCalled();

        $variant = $this->prophesize(ProductVariantInterface::class);
        $variant->getCode()->willReturn('variant-1');
        $product->getVariants()->willReturn([$variant->reveal()]);

        $product->removeVariant($variant->reveal())->shouldBeCalled()->willReturn($product->reveal());

        $handler->__invoke($message->reveal());
    }
}
