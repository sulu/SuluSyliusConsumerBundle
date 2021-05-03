<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Handler;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Adapter\ProductAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Handler\RemoveProductMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Message\RemoveProductMessage;

class RemoveProductMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $adapter1 = $this->prophesize(ProductAdapterInterface::class);
        $adapter2 = $this->prophesize(ProductAdapterInterface::class);
        $handler = new RemoveProductMessageHandler(new \ArrayIterator([$adapter1->reveal(), $adapter2->reveal()]));

        $adapter1->remove('product-1')->shouldBeCalled();
        $adapter2->remove('product-1')->shouldBeCalled();

        $message = $this->prophesize(RemoveProductMessage::class);
        $message->getCode()->willReturn('product-1');

        $handler->__invoke($message->reveal());
    }
}
