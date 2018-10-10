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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Content\Message;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message\ModifyContentMessage;

class ModifyContentMessageTest extends TestCase
{
    public function testGetResourceKey(): void
    {
        $message = new ModifyContentMessage(
            'products',
            'product-1',
            ['type' => 'default', 'data' => ['title' => 'Sulu is awesome']]
        );

        $this->assertEquals('products', $message->getResourceKey());
    }

    public function testGetResourceId(): void
    {
        $message = new ModifyContentMessage(
            'products',
            'product-1',
            ['type' => 'default', 'data' => ['title' => 'Sulu is awesome']]
        );

        $this->assertEquals('product-1', $message->getResourceId());
    }

    public function testGetType(): void
    {
        $message = new ModifyContentMessage(
            'products',
            'product-1',
            ['type' => 'default', 'data' => ['title' => 'Sulu is awesome']]
        );

        $this->assertEquals('default', $message->getType());
    }

    public function testGetData(): void
    {
        $message = new ModifyContentMessage(
            'products',
            'product-1',
            ['type' => 'default', 'data' => ['title' => 'Sulu is awesome']]
        );

        $this->assertEquals(['title' => 'Sulu is awesome'], $message->getData());
    }
}
