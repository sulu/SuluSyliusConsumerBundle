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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Message;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Message\RemoveProductMessage;

class RemoveProductMessageTest extends TestCase
{
    public function testGetMessage(): void
    {
        $message = new RemoveProductMessage('product-1');

        $this->assertEquals('product-1', $message->getCode());
    }
}
