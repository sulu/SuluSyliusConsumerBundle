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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Content\Query;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Query\FindContentQuery;

class FindContentQueryTest extends TestCase
{
    public function testGetResourceKey(): void
    {
        $message = new FindContentQuery('products', 'product-1');

        $this->assertEquals('products', $message->getResourceKey());
    }

    public function testGetResourceId(): void
    {
        $message = new FindContentQuery('products', 'product-1');

        $this->assertEquals('product-1', $message->getResourceId());
    }
}
