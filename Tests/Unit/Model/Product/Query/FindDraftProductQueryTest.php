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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindDraftProductQuery;

class FindDraftProductQueryTest extends TestCase
{
    public function testGetCode(): void
    {
        $query = new FindDraftProductQuery('product-1', 'en');

        $this->assertEquals('product-1', $query->getCode());
    }

    public function testGetLocale(): void
    {
        $query = new FindDraftProductQuery('product-1', 'en');

        $this->assertEquals('en', $query->getLocale());
    }
}
