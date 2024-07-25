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
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Sulu\Bundle\SyliusConsumerBundle\Adapter\ImageAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Handler\SynchronizeImageMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeImageMessage;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;

class SynchronizeImageMessageHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testInvoke(): void
    {
        $adapter1 = $this->prophesize(ImageAdapterInterface::class);
        $adapter2 = $this->prophesize(ImageAdapterInterface::class);
        $handler = new SynchronizeImageMessageHandler(new \ArrayIterator([$adapter1->reveal(), $adapter2->reveal()]));

        $adapter1->synchronize(Argument::that(function(ImagePayload $payload) {
            return 42 === $payload->getId();
        }))->shouldBeCalled();

        $adapter2->synchronize(Argument::that(function(ImagePayload $payload) {
            return 42 === $payload->getId();
        }))->shouldBeCalled();

        $message = $this->prophesize(SynchronizeImageMessage::class);
        $message->getImage()->willReturn(['id' => 42]);
        $message->getLocale()->willReturn('en');

        $handler->__invoke($message->reveal());
    }
}
