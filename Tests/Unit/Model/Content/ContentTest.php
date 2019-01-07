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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Content;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Content;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;

class ContentTest extends TestCase
{
    public function testGetDimension(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $content = new Content($dimension->reveal(), ProductInterface::CONTENT_RESOURCE_KEY, 'product-1');

        $this->assertEquals($dimension->reveal(), $content->getDimension());
    }

    public function testGetResourceKey(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $content = new Content($dimension->reveal(), ProductInterface::CONTENT_RESOURCE_KEY, 'product-1');

        $this->assertEquals(ProductInterface::CONTENT_RESOURCE_KEY, $content->getResourceKey());
    }

    public function testGetResourceId(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $content = new Content($dimension->reveal(), ProductInterface::CONTENT_RESOURCE_KEY, 'product-1');

        $this->assertEquals('product-1', $content->getResourceId());
    }

    public function testGetType(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $content = new Content($dimension->reveal(), ProductInterface::CONTENT_RESOURCE_KEY, 'product-1', 'default');

        $this->assertEquals('default', $content->getType());
    }

    public function testGetData(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $content = new Content(
            $dimension->reveal(),
            ProductInterface::CONTENT_RESOURCE_KEY,
            'product-1',
            'default',
            ['title' => 'Sulu is awesome']
        );

        $this->assertEquals(['title' => 'Sulu is awesome'], $content->getData());
    }

    public function testSetType(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $content = new Content($dimension->reveal(), ProductInterface::CONTENT_RESOURCE_KEY, 'product-1', 'default');

        $this->assertEquals($content, $content->setType('homepage'));
        $this->assertEquals('homepage', $content->getType());
    }

    public function testSetData(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);
        $content = new Content(
            $dimension->reveal(),
            ProductInterface::CONTENT_RESOURCE_KEY,
            'product-1',
            'default',
            ['title' => 'Sulu is great']
        );

        $this->assertEquals($content, $content->setData(['title' => 'Sulu is awesome']));
        $this->assertEquals(['title' => 'Sulu is awesome'], $content->getData());
    }
}
