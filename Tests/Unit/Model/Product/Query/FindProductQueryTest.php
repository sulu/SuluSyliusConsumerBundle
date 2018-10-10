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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductQuery;

class FindProductQueryTest extends TestCase
{
    public function testGetCode(): void
    {
        $query = new FindProductQuery('product-1');

        $this->assertEquals('product-1', $query->getCode());
    }
}
