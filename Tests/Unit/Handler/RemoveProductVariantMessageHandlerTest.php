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
use Sulu\Bundle\SyliusConsumerBundle\Adapter\ProductVariantAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Handler\RemoveProductVariantMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Message\RemoveProductVariantMessage;

class RemoveProductVariantMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $adapter1 = $this->prophesize(ProductVariantAdapterInterface::class);
        $adapter2 = $this->prophesize(ProductVariantAdapterInterface::class);
        $handler = new RemoveProductVariantMessageHandler(new \ArrayIterator([$adapter1->reveal(), $adapter2->reveal()]));

        $adapter1->remove('variant-1')->shouldBeCalled();
        $adapter2->remove('variant-1')->shouldBeCalled();

        $message = $this->prophesize(RemoveProductVariantMessage::class);
        $message->getCode()->willReturn('variant-1');

        $handler->__invoke($message->reveal());
    }
}
