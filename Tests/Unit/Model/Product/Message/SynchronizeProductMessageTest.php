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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product\Message;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;

class SynchronizeProductMessageTest extends TestCase
{
    public function testGetCode(): void
    {
        $message = new SynchronizeProductMessage('product-1', []);

        $this->assertEquals('product-1', $message->getCode());
    }

    public function testGetProduct(): void
    {
        $message = new SynchronizeProductMessage('product-1', ['product' => ['code' => 'product-1']]);

        $this->assertEquals(['code' => 'product-1'], $message->getProduct()->getPayload());
    }
}
