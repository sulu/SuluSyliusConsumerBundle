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
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Handler\Message\ModifyContentMessageHandler;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Message\ModifyContentMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Component\Content\Metadata\Factory\StructureMetadataFactoryInterface;
use Sulu\Component\Content\Metadata\PropertyMetadata;
use Sulu\Component\Content\Metadata\StructureMetadata;

class ModifyContentMessageHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $contentRepository = $this->prophesize(ContentRepositoryInterface::class);
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $factory = $this->prophesize(StructureMetadataFactoryInterface::class);
        $contentViewFactory = $this->prophesize(ContentViewFactoryInterface::class);

        $handler = new ModifyContentMessageHandler(
            $contentRepository->reveal(),
            $dimensionRepository->reveal(),
            $factory->reveal(),
            $contentViewFactory->reveal()
        );

        $message = $this->prophesize(ModifyContentMessage::class);
        $message->getResourceId()->willReturn('product-1');
        $message->getResourceKey()->willReturn(ProductInterface::CONTENT_RESOURCE_KEY);
        $message->getLocale()->willReturn('de');
        $message->getType()->willReturn('default');
        $message->getData()->willReturn(['title' => 'Sulu', 'article' => '<p>Sulu is awesome</p>']);

        $draftDimension = $this->prophesize(DimensionInterface::class);
        $localizedDimension = $this->prophesize(DimensionInterface::class);

        $dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT]
        )->willReturn($draftDimension->reveal());
        $dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => 'de',
            ]
        )->willReturn($localizedDimension->reveal());

        $metadata = $this->prophesize(StructureMetadata::class);
        $titleProperty = $this->prophesize(PropertyMetadata::class);
        $titleProperty->getName()->willReturn('title');
        $titleProperty->isLocalized()->willReturn(true);
        $articleProperty = $this->prophesize(PropertyMetadata::class);
        $articleProperty->getName()->willReturn('article');
        $articleProperty->isLocalized()->willReturn(false);
        $metadata->getProperties()->willReturn([$titleProperty->reveal(), $articleProperty->reveal()]);
        $factory->getStructureMetadata(ProductInterface::CONTENT_RESOURCE_KEY, 'default')->willReturn($metadata->reveal());

        $draftContent = $this->prophesize(ContentInterface::class);
        $draftContent->setType('default')->shouldBeCalled()->willReturn($draftContent->reveal());
        $draftContent->setData(['article' => '<p>Sulu is awesome</p>'])
            ->shouldBeCalled()
            ->willReturn($draftContent->reveal());

        $localizedContent = $this->prophesize(ContentInterface::class);
        $localizedContent->setType('default')->shouldBeCalled()->willReturn($draftContent->reveal());
        $localizedContent->setData(['title' => 'Sulu'])
            ->shouldBeCalled()
            ->willReturn($draftContent->reveal());

        $contentRepository->findOrCreate(ProductInterface::CONTENT_RESOURCE_KEY, 'product-1', $draftDimension->reveal())
            ->shouldBeCalled()
            ->willReturn($draftContent->reveal());

        $contentRepository->findOrCreate(ProductInterface::CONTENT_RESOURCE_KEY, 'product-1', $localizedDimension->reveal())
            ->shouldBeCalled()
            ->willReturn($localizedContent->reveal());

        $contentView = $this->prophesize(ContentViewInterface::class);
        $contentViewFactory->create([$localizedContent->reveal(), $draftContent->reveal()])
            ->willReturn($contentView->reveal());

        $message->setContent($contentView->reveal())->shouldBeCalled()->willReturn($message->reveal());
        $handler->__invoke($message->reveal());
    }
}
