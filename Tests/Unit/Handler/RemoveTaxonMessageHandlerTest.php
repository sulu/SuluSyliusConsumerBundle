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
use Sulu\Bundle\SyliusConsumerBundle\Adapter\TaxonAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Handler\RemoveTaxonMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Message\RemoveTaxonMessage;

class RemoveTaxonMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $adapter1 = $this->prophesize(TaxonAdapterInterface::class);
        $adapter2 = $this->prophesize(TaxonAdapterInterface::class);
        $handler = new RemoveTaxonMessageHandler(new \ArrayIterator([$adapter1->reveal(), $adapter2->reveal()]));

        $adapter1->remove(42)->shouldBeCalled();
        $adapter2->remove(42)->shouldBeCalled();

        $message = $this->prophesize(RemoveTaxonMessage::class);
        $message->getId()->willReturn(42);

        $handler->__invoke($message->reveal());
    }
}
