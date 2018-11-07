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

use JMS\Serializer\Context;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sulu\Bundle\CategoryBundle\Api\Category;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\SyliusConsumerBundle\EventSubscriber\ProductViewSerializerSubscriber;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Sulu\Component\Content\Compat\StructureManagerInterface;
use Sulu\Component\Content\ContentTypeInterface;
use Sulu\Component\Content\ContentTypeManagerInterface;
use Sulu\Component\Serializer\ArraySerializationVisitor;

class ProductViewSerializerSubscriberTest extends TestCase
{
    public function testOnPostSerialize(): void
    {
        $structureManager = $this->prophesize(StructureManagerInterface::class);
        $contentTypeManager = $this->prophesize(ContentTypeManagerInterface::class);

        $eventSubscriber = new ProductViewSerializerSubscriber($structureManager->reveal(), $contentTypeManager->reveal());

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');

        $productInformation = $this->prophesize(ProductInformationInterface::class);

        $contentView = $this->prophesize(ContentViewInterface::class);
        $contentView->getType()->willReturn('default');
        $contentView->getData()->willReturn(['title' => 'Sulu is awesome']);

        $mainCategory = $this->prophesize(Category::class);

        $category1 = $this->prophesize(Category::class);
        $category2 = $this->prophesize(Category::class);

        $media1 = $this->prophesize(Media::class);
        $media2 = $this->prophesize(Media::class);

        $productView = $this->prophesize(ProductViewInterface::class);
        $productView->getLocale()->willReturn('en');
        $productView->getContent()->willReturn($contentView->reveal());
        $productView->getProduct()->willReturn($product->reveal());
        $productView->getProductInformation()->willReturn($productInformation->reveal());
        $productView->getMainCategory()->willReturn($mainCategory->reveal());
        $productView->getCategories()->willReturn([$category1->reveal(), $category2->reveal()]);
        $productView->getMedia()->willReturn([$media1->reveal(), $media2->reveal()]);

        $event = $this->prophesize(ObjectEvent::class);
        $visitor = $this->prophesize(ArraySerializationVisitor::class);
        $context = $this->prophesize(Context::class);
        $context->accept($product->reveal())->willReturn(['product_data' => '123']);
        $context->accept($productInformation->reveal())->willReturn(['product_information_data' => '456']);
        $event->getVisitor()->willReturn($visitor->reveal());
        $event->getObject()->willReturn($productView->reveal());
        $event->getContext()->willReturn($context->reveal());

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

        $expectedProductData = [
            'product_data' => '123',
            'product_information_data' => '456',
            'mainCategory' => $mainCategory->reveal(),
            'categories' => [$category1->reveal(), $category2->reveal()],
            'media' => [$media1->reveal(), $media2->reveal()],
            'customData' => [],
        ];

        $visitor->setData(
            'product',
            Argument::that(function ($productData) use ($expectedProductData) {
                $this->assertEquals($expectedProductData, $productData);

                return true;
            })
        )->shouldBeCalled();
        $visitor->setData('content', ['title' => 'Sulu is awesome'])->shouldBeCalled();
        $visitor->setData('view', ['title' => []])->shouldBeCalled();
        $visitor->setData('extension', [])->shouldBeCalled();
        $visitor->setData('urls', [])->shouldBeCalled();
        $visitor->setData('template', 'default')->shouldBeCalled();

        $eventSubscriber->onPostSerialize($event->reveal());
    }
}
