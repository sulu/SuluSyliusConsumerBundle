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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product\Handler\Message;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sulu\Bundle\CategoryBundle\Category\CategoryManagerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Message\RemoveTaxonMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\RemoveTaxonMessage;

class RemoveTaxonMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $message = $this->prophesize(RemoveTaxonMessage::class);
        $message->getId()->willReturn(1);

        $categoryRepository = $this->prophesize(CategoryRepositoryInterface::class);
        $categoryManager = $this->prophesize(CategoryManagerInterface::class);
        $handler = new RemoveTaxonMessageHandler(
            $categoryRepository->reveal(),
            $categoryManager->reveal()
        );

        $categoryRepository->findIdBySyliusId(1)->willReturn(42);
        $categoryManager->delete(42)->shouldBeCalled();

        $handler->__invoke($message->reveal());
    }

    public function testInvokeProductNotFound(): void
    {
        $message = $this->prophesize(RemoveTaxonMessage::class);
        $message->getId()->willReturn(1);

        $categoryRepository = $this->prophesize(CategoryRepositoryInterface::class);
        $categoryManager = $this->prophesize(CategoryManagerInterface::class);
        $handler = new RemoveTaxonMessageHandler(
            $categoryRepository->reveal(),
            $categoryManager->reveal()
        );

        $categoryRepository->findIdBySyliusId(1)->willReturn(null);
        $categoryManager->delete(Argument::any())->shouldNotBeCalled();

        $handler->__invoke($message->reveal());
    }
}
