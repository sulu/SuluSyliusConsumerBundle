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
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeProductVariantMessage;

class SynchronizeProductVariantMessageTest extends TestCase
{
    public function testGetProductCode(): void
    {
        $message = new SynchronizeProductVariantMessage('product-1', 'variant-1', ['product' => []]);

        $this->assertEquals('product-1', $message->getProductCode());
    }

    public function testGetCode(): void
    {
        $message = new SynchronizeProductVariantMessage('product-1', 'variant-1', ['product' => []]);

        $this->assertEquals('variant-1', $message->getCode());
    }

    public function testGetPayload(): void
    {
        $message = new SynchronizeProductVariantMessage('product-1', 'variant-1', ['product' => []]);

        $this->assertEquals(['product' => []], $message->getPayload());
    }
}
