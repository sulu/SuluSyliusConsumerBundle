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
use Sulu\Bundle\SyliusConsumerBundle\Adapter\ProductVariantAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Handler\SynchronizeProductVariantMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeProductVariantMessage;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ProductVariantPayload;

class SynchronizeProductVariantMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $adapter1 = $this->prophesize(ProductVariantAdapterInterface::class);
        $adapter2 = $this->prophesize(ProductVariantAdapterInterface::class);
        $handler = new SynchronizeProductVariantMessageHandler(new \ArrayIterator([$adapter1->reveal(), $adapter2->reveal()]));

        $adapter1->synchronize(Argument::that(function (ProductVariantPayload $payload) {
            return 'variant-1' === $payload->getCode()
                && 'product-1' === $payload->getProductCode();
        }))->shouldBeCalled();

        $adapter2->synchronize(Argument::that(function (ProductVariantPayload $payload) {
            return 'variant-1' === $payload->getCode()
                && 'product-1' === $payload->getProductCode();
        }))->shouldBeCalled();

        $message = $this->prophesize(SynchronizeProductVariantMessage::class);
        $message->getCode()->willReturn('variant-1');
        $message->getProductCode()->willReturn('product-1');
        $message->getPayload()->willReturn(['code' => 'variant-1']);

        $handler->__invoke($message->reveal());
    }
}
