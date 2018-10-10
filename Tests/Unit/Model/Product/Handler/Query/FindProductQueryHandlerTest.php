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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product\Handler\Query;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Query\FindProductQueryHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductQuery;

class FindProductQueryHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $repository = $this->prophesize(ProductRepositoryInterface::class);

        $handler = new FindProductQueryHandler($repository->reveal());

        $message = $this->prophesize(FindProductQuery::class);
        $message->getCode()->willReturn('product-1');

        $product = $this->prophesize(ProductInterface::class);
        $repository->findByCode('product-1')->willReturn($product->reveal())->shouldBeCalled();

        $result = $handler->__invoke($message->reveal());
        $this->assertEquals($product->reveal(), $result);
    }

    public function testInvokeProductNotFound(): void
    {
        $this->expectException(ProductNotFoundException::class);

        $repository = $this->prophesize(ProductRepositoryInterface::class);

        $handler = new FindProductQueryHandler($repository->reveal());

        $message = $this->prophesize(FindProductQuery::class);
        $message->getCode()->willReturn('product-1');

        $repository->findByCode('product-1')->willReturn(null);

        $handler->__invoke($message->reveal());
    }
}
