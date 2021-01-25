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
use Sulu\Bundle\SyliusConsumerBundle\Adapter\TaxonAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Handler\SynchronizeTaxonMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeTaxonMessage;
use Sulu\Bundle\SyliusConsumerBundle\Payload\TaxonPayload;

class SynchronizeTaxonMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $adapter1 = $this->prophesize(TaxonAdapterInterface::class);
        $adapter2 = $this->prophesize(TaxonAdapterInterface::class);
        $handler = new SynchronizeTaxonMessageHandler(new \ArrayIterator([$adapter1->reveal(), $adapter2->reveal()]));

        $adapter1->synchronize(Argument::that(function (TaxonPayload $payload) {
            return 42 === $payload->getId();
        }))->shouldBeCalled();

        $adapter2->synchronize(Argument::that(function (TaxonPayload $payload) {
            return 42 === $payload->getId();
        }))->shouldBeCalled();

        $message = $this->prophesize(SynchronizeTaxonMessage::class);
        $message->getId()->willReturn(42);
        $message->getPayload()->willReturn(['id' => 42]);

        $handler->__invoke($message->reveal());
    }
}
