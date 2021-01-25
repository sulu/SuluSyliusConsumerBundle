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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Handler;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sulu\Bundle\SyliusConsumerBundle\Adapter\ProductAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Handler\SynchronizeProductMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ProductPayload;

class SynchronizeProductMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $adapter1 = $this->prophesize(ProductAdapterInterface::class);
        $adapter2 = $this->prophesize(ProductAdapterInterface::class);
        $handler = new SynchronizeProductMessageHandler(new \ArrayIterator([$adapter1->reveal(), $adapter2->reveal()]));

        $adapter1->synchronize(Argument::that(function (ProductPayload $payload) {
            return 'product-1' === $payload->getCode();
        }))->shouldBeCalled();

        $adapter2->synchronize(Argument::that(function (ProductPayload $payload) {
            return 'product-1' === $payload->getCode();
        }))->shouldBeCalled();

        $message = $this->prophesize(SynchronizeProductMessage::class);
        $message->getCode()->willReturn('product-1');
        $message->getPayload()->willReturn(['code' => 'product-1']);

        $handler->__invoke($message->reveal());
    }
}
