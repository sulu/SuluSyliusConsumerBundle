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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Message;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeProductMessage;

class SynchronizeProductMessageTest extends TestCase
{
    public function testGetCode(): void
    {
        $message = new SynchronizeProductMessage('product-1', ['variants' => []]);

        $this->assertEquals('product-1', $message->getCode());
    }

    public function testGetPayload(): void
    {
        $message = new SynchronizeProductMessage('product-1', ['variants' => []]);

        $this->assertEquals(['variants' => []], $message->getPayload());
    }
}
