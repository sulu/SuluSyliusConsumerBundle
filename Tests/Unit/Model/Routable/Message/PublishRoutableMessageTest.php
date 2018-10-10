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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Routable\Message;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\Message\PublishRoutableMessage;

class PublishRoutableMessageTest extends TestCase
{
    public function testGetResourceKey(): void
    {
        $message = new PublishRoutableMessage(ProductInterface::RESOURCE_KEY, 'product-1', 'en', '/products/product-1');

        $this->assertEquals(ProductInterface::RESOURCE_KEY, $message->getResourceKey());
    }

    public function testGetResourceId(): void
    {
        $message = new PublishRoutableMessage(ProductInterface::RESOURCE_KEY, 'product-1', 'en', '/products/product-1');

        $this->assertEquals('product-1', $message->getResourceId());
    }

    public function testGetLocale(): void
    {
        $message = new PublishRoutableMessage(ProductInterface::RESOURCE_KEY, 'product-1', 'en', '/products/product-1');

        $this->assertEquals('en', $message->getLocale());
    }

    public function testGetRoutePath(): void
    {
        $message = new PublishRoutableMessage(ProductInterface::RESOURCE_KEY, 'product-1', 'en', '/products/product-1');

        $this->assertEquals('/products/product-1', $message->getRoutePath());
    }
}
