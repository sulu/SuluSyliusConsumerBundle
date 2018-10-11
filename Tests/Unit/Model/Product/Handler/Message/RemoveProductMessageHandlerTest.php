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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductDataNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Message\RemoveProductMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\RemoveProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class RemoveProductMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $message = $this->prophesize(RemoveProductMessage::class);
        $message->getCode()->willReturn('product-1');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productDataRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $handler = new RemoveProductMessageHandler($productRepository->reveal(), $productDataRepository->reveal());

        $product = $this->prophesize(ProductInterface::class);
        $productRepository->findByCode('product-1')->willReturn($product->reveal());
        $productRepository->remove($product->reveal())->shouldBeCalled();

        $productData = $this->prophesize(ProductDataInterface::class);
        $productDataRepository->findAllByCode('product-1')->willReturn([$productData->reveal()]);
        $productDataRepository->remove($productData->reveal())->shouldBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeProductNotFound(): void
    {
        $this->expectException(ProductNotFoundException::class);

        $message = $this->prophesize(RemoveProductMessage::class);
        $message->getCode()->willReturn('product-1');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productDataRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $handler = new RemoveProductMessageHandler($productRepository->reveal(), $productDataRepository->reveal());

        $productRepository->findByCode('product-1')->willReturn(null);
        $productRepository->remove(Argument::any())->shouldNotBeCalled();
        $productDataRepository->remove(Argument::any())->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeProductDataNotFound(): void
    {
        $this->expectException(ProductDataNotFoundException::class);

        $message = $this->prophesize(RemoveProductMessage::class);
        $message->getCode()->willReturn('product-1');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productDataRepository = $this->prophesize(ProductDataRepositoryInterface::class);
        $handler = new RemoveProductMessageHandler($productRepository->reveal(), $productDataRepository->reveal());

        $product = $this->prophesize(ProductInterface::class);
        $productRepository->findByCode('product-1')->willReturn($product->reveal());
        $productRepository->remove($product->reveal())->shouldBeCalled();

        $productDataRepository->findAllByCode('product-1')->willReturn([]);
        $productDataRepository->remove(Argument::any())->shouldNotBeCalled();
        $productDataRepository->remove(Argument::any())->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }
}
