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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Content\Types;

use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sulu\Bundle\SyliusConsumerBundle\Content\ProxyFactory;
use Sulu\Bundle\SyliusConsumerBundle\Content\Types\ProductSelectionContentType;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductViewsQuery;
use Sulu\Bundle\WebsiteBundle\ReferenceStore\ReferenceStoreInterface;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductSelectionContentTypeTest extends TestCase
{
    public function testGetContentData(): void
    {
        $messageBus = $this->prophesize(MessageBusInterface::class);
        $serializer = $this->prophesize(SerializerInterface::class);
        $productReferenceStore = $this->prophesize(ReferenceStoreInterface::class);
        $proxyFactory = $this->prophesize(ProxyFactory::class);

        $contentType = new ProductSelectionContentType(
            $messageBus->reveal(),
            $serializer->reveal(),
            $productReferenceStore->reveal(),
            $proxyFactory->reveal()
        );

        $structure = $this->prophesize(StructureInterface::class);
        $structure->getLanguageCode()->willReturn('en');

        $property = $this->prophesize(PropertyInterface::class);
        $property->getValue()->willReturn(['111-111-111', '222-222-222']);
        $property->getStructure()->willReturn($structure->reveal());

        $productViews = [
            $this->prophesize(ProductViewInterface::class),
            $this->prophesize(ProductViewInterface::class),
        ];

        $messageBus->dispatch(
            Argument::that(
                function (FindProductViewsQuery $query) use ($productViews) {
                    $query->setProductViews($productViews);

                    return ['111-111-111', '222-222-222'] === $query->getIds() && 'en' === $query->getLocale();
                }
            )
        )->willReturn(new Envelope(new \stdClass()))->shouldBeCalled();

        $result = new \ArrayObject();
        $proxyFactory->createProxy($serializer->reveal(), $productViews)->willReturn($result)->shouldBeCalled();

        $contentData = $contentType->getContentData($property->reveal());

        $this->assertEquals($result, $contentData);
    }

    public function testPreResolve(): void
    {
        $messageBus = $this->prophesize(MessageBusInterface::class);
        $serializer = $this->prophesize(SerializerInterface::class);
        $productReferenceStore = $this->prophesize(ReferenceStoreInterface::class);
        $proxyFactory = $this->prophesize(ProxyFactory::class);

        $contentType = new ProductSelectionContentType(
            $messageBus->reveal(),
            $serializer->reveal(),
            $productReferenceStore->reveal(),
            $proxyFactory->reveal()
        );

        $structure = $this->prophesize(StructureInterface::class);
        $structure->getLanguageCode()->willReturn('en');

        $property = $this->prophesize(PropertyInterface::class);
        $property->getValue()->willReturn(['111-111-111', '222-222-222']);
        $property->getStructure()->willReturn($structure->reveal());

        $productReferenceStore->add('111-111-111')->shouldBeCalled();
        $productReferenceStore->add('222-222-222')->shouldBeCalled();

        $contentType->preResolve($property->reveal());
    }
}
