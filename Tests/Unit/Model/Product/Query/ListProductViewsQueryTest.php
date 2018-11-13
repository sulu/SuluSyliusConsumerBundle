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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\ListProductViewsQuery;

class ListProductViewsQueryTest extends TestCase
{
    public function testGetMin(): void
    {
        $query = new ListProductViewsQuery('en');

        $this->assertEquals('en', $query->getLocale());
    }

    public function testGetMax(): void
    {
        $query = new ListProductViewsQuery(
            'en',
            1,
            10,
            'abc',
            ['c1', 'c2'],
            ['a1' => 'av1', 'a2' => 'av2']
        );

        $this->assertEquals('en', $query->getLocale());
        $this->assertEquals(1, $query->getPage());
        $this->assertEquals(10, $query->getPageSize());
        $this->assertEquals('abc', $query->getQuery());
        $this->assertEquals(['c1', 'c2'], $query->getCategoryKeys());
        $this->assertEquals(['a1' => 'av1', 'a2' => 'av2'], $query->getAttributeFilters());
    }
}
