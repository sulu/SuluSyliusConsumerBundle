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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Message\RemoveProductMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\RemoveProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class RemoveProductMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $message = $this->prophesize(RemoveProductMessage::class);
        $message->getCode()->willReturn('product-1');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $handler = new RemoveProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $productRepository->findByCode('product-1')->willReturn($product->reveal());
        $productRepository->remove($product->reveal())->shouldBeCalled();

        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productInformationRepository->findAllById('123-123-123')->willReturn([$productInformation->reveal()]);
        $productInformationRepository->remove($productInformation->reveal())->shouldBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeProductNotFound(): void
    {
        $this->expectException(ProductNotFoundException::class);

        $message = $this->prophesize(RemoveProductMessage::class);
        $message->getCode()->willReturn('product-1');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $handler = new RemoveProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal()
        );

        $productRepository->findByCode('product-1')->willReturn(null);
        $productRepository->remove(Argument::any())->shouldNotBeCalled();
        $productInformationRepository->remove(Argument::any())->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeProductInformationNotFound(): void
    {
        $this->expectException(ProductInformationNotFoundException::class);

        $message = $this->prophesize(RemoveProductMessage::class);
        $message->getCode()->willReturn('product-1');

        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productInformationRepository = $this->prophesize(ProductInformationRepositoryInterface::class);
        $handler = new RemoveProductMessageHandler(
            $productRepository->reveal(),
            $productInformationRepository->reveal()
        );

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $productRepository->findByCode('product-1')->willReturn($product->reveal());
        $productRepository->remove($product->reveal())->shouldBeCalled();

        $productInformationRepository->findAllById('123-123-123')->willReturn([]);
        $productInformationRepository->remove(Argument::any())->shouldNotBeCalled();
        $productInformationRepository->remove(Argument::any())->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }
}
