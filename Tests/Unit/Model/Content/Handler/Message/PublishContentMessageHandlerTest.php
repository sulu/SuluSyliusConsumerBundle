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
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Handler\Message\PublishContentMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message\PublishContentMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;

class PublishContentMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $contentRepository = $this->prophesize(ContentRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $contentViewFactory = $this->prophesize(ContentViewFactoryInterface::class);

        $handler = new PublishContentMessageHandler(
            $contentRepository->reveal(),
            $dimensionRepository->reveal(),
            $contentViewFactory->reveal()
        );

        $message = $this->prophesize(PublishContentMessage::class);
        $message->getResourceKey()->willReturn(ProductInterface::RESOURCE_KEY);
        $message->getResourceId()->willReturn('product-1');
        $message->getLocale()->willReturn('en');

        $draftDimension = $this->prophesize(DimensionInterface::class);
        $liveDimension = $this->prophesize(DimensionInterface::class);

        $localizedDraftDimension = $this->prophesize(DimensionInterface::class);
        $localizedLiveDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($draftDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($localizedDraftDimension->reveal());

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE]
        )->willReturn($liveDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'en',
            ]
        )->willReturn($localizedLiveDimension->reveal());

        $draftContent = $this->prophesize(ContentInterface::class);
        $draftContent->getType()->willReturn('default');
        $draftContent->getData()->willReturn(['article' => '<p>Sulu is awesome</p>']);
        $draftContent->getDimension()->willReturn($draftDimension->reveal());

        $liveContent = $this->prophesize(ContentInterface::class);
        $liveContent->setType('default')->shouldBeCalled();
        $liveContent->setData(['article' => '<p>Sulu is awesome</p>'])->shouldBeCalled();
        $draftContent->getDimension()->willReturn($liveDimension->reveal());

        $localizedDraftContent = $this->prophesize(ContentInterface::class);
        $localizedDraftContent->getType()->willReturn('default');
        $localizedDraftContent->getData()->willReturn(['title' => 'Sulu']);

        $localizedLiveContent = $this->prophesize(ContentInterface::class);
        $localizedLiveContent->setType('default')->shouldBeCalled();
        $localizedLiveContent->setData(['title' => 'Sulu'])->shouldBeCalled();

        $contentRepository->findByResource(ProductInterface::RESOURCE_KEY, 'product-1', $draftDimension->reveal())
            ->willReturn($draftContent);

        $contentRepository->findOrCreate(ProductInterface::RESOURCE_KEY, 'product-1', $liveDimension->reveal())
            ->willReturn($liveContent);

        $contentRepository->findByResource(ProductInterface::RESOURCE_KEY, 'product-1', $localizedDraftDimension->reveal())
            ->willReturn($localizedDraftContent);

        $contentRepository->findOrCreate(ProductInterface::RESOURCE_KEY, 'product-1', $localizedLiveDimension->reveal())
            ->willReturn($localizedLiveContent);

        $content = $this->prophesize(ContentInterface::class);
        $contentViewFactory->create([$liveContent->reveal(), $localizedLiveContent->reveal()])
            ->willReturn($content->reveal());

        $result = $handler->__invoke($message->reveal());

        $this->assertEquals($content->reveal(), $result);
    }
}
