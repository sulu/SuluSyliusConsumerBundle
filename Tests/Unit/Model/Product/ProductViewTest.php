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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductView;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;

class ProductViewTest extends TestCase
{
    public function testGetter(): void
    {
        $product = $this->prophesize(ProductInterface::class);
        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $content = $this->prophesize(ContentViewInterface::class);
        $routableResource = $this->prophesize(RoutableResourceInterface::class);

        $productView = new ProductView(
            'de',
            $product->reveal(),
            $productInformation->reveal(),
            $content->reveal(),
            $routableResource->reveal()
        );

        $this->assertEquals('de', $productView->getLocale());
        $this->assertEquals($product->reveal(), $productView->getProduct());
        $this->assertEquals($productInformation->reveal(), $productView->getProductInformation());
        $this->assertEquals($content->reveal(), $productView->getContent());
        $this->assertEquals($routableResource->reveal(), $productView->getRoutableResource());
    }
}
