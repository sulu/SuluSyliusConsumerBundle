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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Content\Handler\Query;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Exception\ContentNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Handler\Query\FindContentQueryHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Query\FindContentQuery;

class FindContentQueryHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $repository = $this->prophesize(ContentRepositoryInterface::class);

        $handler = new FindContentQueryHandler($repository->reveal());

        $message = $this->prophesize(FindContentQuery::class);
        $message->getResourceId()->willReturn('product-1');
        $message->getResourceKey()->willReturn('products');

        $content = $this->prophesize(ContentInterface::class);
        $repository->findByResource('products', 'product-1')->willReturn($content->reveal())->shouldBeCalled();

        $result = $handler->__invoke($message->reveal());
        $this->assertEquals($content->reveal(), $result);
    }

    public function testInvokeContentNotFound(): void
    {
        $this->expectException(ContentNotFoundException::class);

        $repository = $this->prophesize(ContentRepositoryInterface::class);

        $handler = new FindContentQueryHandler($repository->reveal());

        $message = $this->prophesize(FindContentQuery::class);
        $message->getResourceId()->willReturn('product-1');
        $message->getResourceKey()->willReturn('products');

        $repository->findByResource('products', 'product-1')->willReturn(null)->shouldBeCalled();

        $handler->__invoke($message->reveal());
    }
}
