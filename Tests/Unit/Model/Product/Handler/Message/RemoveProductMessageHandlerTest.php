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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Message\RemoveProductMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\RemoveProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class RemoveProductMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $message = $this->prophesize(RemoveProductMessage::class);
        $message->getCode()->willReturn('product-1');

        $repository = $this->prophesize(ProductRepositoryInterface::class);
        $handler = new RemoveProductMessageHandler($repository->reveal());

        $product = $this->prophesize(ProductInterface::class);
        $repository->findAllByCode('product-1')->willReturn([$product->reveal()]);
        $repository->remove($product->reveal())->shouldBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeProductNotFound(): void
    {
        $this->expectException(ProductNotFoundException::class);

        $message = $this->prophesize(RemoveProductMessage::class);
        $message->getCode()->willReturn('product-1');

        $repository = $this->prophesize(ProductRepositoryInterface::class);
        $handler = new RemoveProductMessageHandler($repository->reveal());

        $repository->findAllByCode('product-1')->willReturn([]);
        $repository->remove(Argument::any())->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }
}
