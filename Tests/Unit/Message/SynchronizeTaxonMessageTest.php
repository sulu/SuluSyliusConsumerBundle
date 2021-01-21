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
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeTaxonMessage;

class SynchronizeTaxonMessageTest extends TestCase
{
    public function testGetId(): void
    {
        $message = new SynchronizeTaxonMessage(1, ['name' => []]);

        $this->assertEquals(1, $message->getId());
    }

    public function testGetPayload(): void
    {
        $message = new SynchronizeTaxonMessage(1, ['name' => []]);

        $this->assertEquals(['name' => []], $message->getPayload());
    }
}
