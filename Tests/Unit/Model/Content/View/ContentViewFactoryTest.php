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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Content\View;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;

class ContentViewFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $contentRepository = $this->prophesize(ContentRepositoryInterface::class);

        $factory = new ContentViewFactory($contentRepository->reveal());

        $dimension = $this->prophesize(DimensionInterface::class);

        $contentDimension1 = $this->prophesize(ContentInterface::class);
        $contentDimension1->getDimension()->willReturn($dimension->reveal());
        $contentDimension1->getResourceKey()->willReturn(ProductInterface::CONTENT_RESOURCE_KEY);
        $contentDimension1->getResourceId()->willReturn('product-1');
        $contentDimension1->getType()->willReturn('default');
        $contentDimension1->getData()->willReturn(['title' => 'Sulu']);

        $contentDimension2 = $this->prophesize(ContentInterface::class);
        $contentDimension2->getData()->willReturn(['article' => '<p>Sulu is awesome</p>']);

        $result = $factory->create([$contentDimension1->reveal(), $contentDimension2->reveal()]);

        if (!$result) {
            $this->fail('Result is null');
        }

        $this->assertEquals(ProductInterface::CONTENT_RESOURCE_KEY, $result->getResourceKey());
        $this->assertEquals('product-1', $result->getResourceId());
        $this->assertEquals('default', $result->getType());
        $this->assertEquals(['title' => 'Sulu', 'article' => '<p>Sulu is awesome</p>'], $result->getData());
    }

    public function testLoadAndCreate(): void
    {
        $contentRepository = $this->prophesize(ContentRepositoryInterface::class);

        $factory = new ContentViewFactory($contentRepository->reveal());

        $localizedDimension = $this->prophesize(DimensionInterface::class);
        $draftDimension = $this->prophesize(DimensionInterface::class);

        $contentDimension1 = $this->prophesize(ContentInterface::class);
        $contentDimension1->getDimension()->willReturn($localizedDimension->reveal());
        $contentDimension1->getResourceKey()->willReturn(ProductInterface::CONTENT_RESOURCE_KEY);
        $contentDimension1->getResourceId()->willReturn('product-1');
        $contentDimension1->getType()->willReturn('default');
        $contentDimension1->getData()->willReturn(['title' => 'Sulu']);

        $contentDimension2 = $this->prophesize(ContentInterface::class);
        $contentDimension2->getData()->willReturn(['article' => '<p>Sulu is awesome</p>']);

        $contentRepository->findByDimensions(
            ProductInterface::CONTENT_RESOURCE_KEY,
            'product-1',
            [$localizedDimension, $draftDimension]
        )->willReturn([$contentDimension1, $contentDimension2]);

        $result = $factory->loadAndCreate(
            ProductInterface::CONTENT_RESOURCE_KEY,
            'product-1',
            [$localizedDimension->reveal(), $draftDimension->reveal()]
        );

        if (!$result) {
            $this->fail('Result is null');
        }

        $this->assertEquals(ProductInterface::CONTENT_RESOURCE_KEY, $result->getResourceKey());
        $this->assertEquals('product-1', $result->getResourceId());
        $this->assertEquals('default', $result->getType());
        $this->assertEquals(['title' => 'Sulu', 'article' => '<p>Sulu is awesome</p>'], $result->getData());
    }

    public function testCreateNull(): void
    {
        $contentRepository = $this->prophesize(ContentRepositoryInterface::class);

        $factory = new ContentViewFactory($contentRepository->reveal());

        $this->assertNull($factory->create([]));
    }
}
