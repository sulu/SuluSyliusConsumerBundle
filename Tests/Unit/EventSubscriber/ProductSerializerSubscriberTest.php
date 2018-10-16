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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\EventSubscriber;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\EventSubscriber\ProductSerializerSubscriber;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Content\Compat\StructureManagerInterface;
use Sulu\Component\Content\ContentTypeInterface;
use Sulu\Component\Content\ContentTypeManagerInterface;
use Sulu\Component\Serializer\ArraySerializationVisitor;

class ProductSerializerSubscriberTest extends TestCase
{
    public function testOnPostSerialize(): void
    {
        $structureManager = $this->prophesize(StructureManagerInterface::class);
        $contentTypeManager = $this->prophesize(ContentTypeManagerInterface::class);

        $eventSubscriber = new ProductSerializerSubscriber($structureManager->reveal(), $contentTypeManager->reveal());

        $product = $this->prophesize(ProductViewInterface::class);
        $product->getContentType()->willReturn('default');
        $product->getContentData()->willReturn(['title' => 'Sulu is awesome']);
        $product->getLocale()->willReturn('en');

        $event = $this->prophesize(ObjectEvent::class);
        $visitor = $this->prophesize(ArraySerializationVisitor::class);
        $event->getVisitor()->willReturn($visitor->reveal());
        $event->getObject()->willReturn($product->reveal());

        $property = $this->prophesize(PropertyInterface::class);
        $property->getName()->willReturn('title');
        $property->getContentTypeName()->willReturn('text_line');

        $structure = $this->prophesize(StructureInterface::class);
        $structure->getProperties(true)->willReturn([$property->reveal()]);

        $structureManager->getStructure('default', ProductInterface::RESOURCE_KEY)->willReturn($structure->reveal());

        $contentType = $this->prophesize(ContentTypeInterface::class);
        $contentTypeManager->get('text_line')->willReturn($contentType->reveal());

        $contentType->getContentData($property->reveal())->willReturn('Sulu is awesome');
        $contentType->getViewData($property->reveal())->willReturn([]);

        $structure->setLanguageCode('en')->shouldBeCalled();
        $property->setValue('Sulu is awesome')->shouldBeCalled();
        $visitor->setData('product', $product->reveal())->shouldBeCalled();
        $visitor->setData('content', ['title' => 'Sulu is awesome'])->shouldBeCalled();
        $visitor->setData('view', ['title' => []])->shouldBeCalled();
        $visitor->setData('extension', [])->shouldBeCalled();
        $visitor->setData('urls', [])->shouldBeCalled();

        $eventSubscriber->onPostSerialize($event->reveal());
    }
}
