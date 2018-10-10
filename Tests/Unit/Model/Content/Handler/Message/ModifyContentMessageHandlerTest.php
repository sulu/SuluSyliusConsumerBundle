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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Content\Handler\Message;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Handler\Message\ModifyContentMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message\ModifyContentMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;

class ModifyContentMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $repository = $this->prophesize(ContentRepositoryInterface::class);

        $handler = new ModifyContentMessageHandler($repository->reveal());

        $message = $this->prophesize(ModifyContentMessage::class);
        $message->getResourceId()->willReturn('product-1');
        $message->getResourceKey()->willReturn(ProductInterface::RESOURCE_KEY);
        $message->getType()->willReturn('default');
        $message->getData()->willReturn(['title' => 'Sulu is awesome']);

        $content = $this->prophesize(ContentInterface::class);
        $content->setType('default')->shouldBeCalled()->willReturn($content->reveal());
        $content->setData(['title' => 'Sulu is awesome'])->shouldBeCalled()->willReturn($content->reveal());

        $repository->findOrCreate(ProductInterface::RESOURCE_KEY, 'product-1')->shouldBeCalled()->willReturn($content->reveal());

        $result = $handler->__invoke($message->reveal());
        $this->assertEquals($content->reveal(), $result);
    }
}
