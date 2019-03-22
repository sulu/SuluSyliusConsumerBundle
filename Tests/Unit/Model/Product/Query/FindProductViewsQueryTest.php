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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product\Query;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductViewsQuery;

class FindProductViewsQueryTest extends TestCase
{
    public function testGetIds(): void
    {
        $query = new FindProductViewsQuery(['123-123-123', '222-222-222'], 'en');

        $this->assertEquals(['123-123-123', '222-222-222'], $query->getIds());
    }

    public function testGetLocale(): void
    {
        $query = new FindProductViewsQuery(['123-123-123', '222-222-222'], 'en');

        $this->assertEquals('en', $query->getLocale());
    }
}
