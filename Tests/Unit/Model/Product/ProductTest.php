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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;

class ProductTest extends TestCase
{
    public function testGetId(): void
    {
        $id = Uuid::uuid4()->toString();
        $product = new Product($id, 'product-1');

        $this->assertEquals($id, $product->getId());
    }

    public function testGetCode(): void
    {
        $product = new Product(Uuid::uuid4()->toString(), 'product-1');

        $this->assertEquals('product-1', $product->getCode());
    }
}
