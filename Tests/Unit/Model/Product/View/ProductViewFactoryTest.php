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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Product\View;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sulu\Bundle\CategoryBundle\Api\Category;
use Sulu\Bundle\CategoryBundle\Category\CategoryManagerInterface;
use Sulu\Bundle\MediaBundle\Api\Media as ApiMedia;
use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;
use Sulu\Bundle\RouteBundle\Model\RouteInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReference;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactory;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceRepositoryInterface;

class ProductViewFactoryTest extends TestCase
{
    public function testCreate()
    {
        $dimensionRepository = $this->prophesize(DimensionRepositoryInterface::class);
        $routableResourceRepository = $this->prophesize(RoutableResourceRepositoryInterface::class);
        $contentViewFactory = $this->prophesize(ContentViewFactoryInterface::class);
        $mediaManager = $this->prophesize(MediaManagerInterface::class);
        $categoryManager = $this->prophesize(CategoryManagerInterface::class);

        $factory = new ProductViewFactory(
            $dimensionRepository->reveal(),
            $routableResourceRepository->reveal(),
            $contentViewFactory->reveal(),
            $mediaManager->reveal(),
            $categoryManager->reveal()
        );

        $dimension = $this->prophesize(DimensionInterface::class);
        $dimension->hasAttribute('locale')->willReturn(true);
        $dimension->getAttributeValue('locale')->willReturn('de');

        $mainCategory = $this->prophesize(CategoryInterface::class);

        $productCategory1 = $this->prophesize(CategoryInterface::class);
        $productCategory2 = $this->prophesize(CategoryInterface::class);
        $productCategories = [$productCategory1->reveal(), $productCategory2->reveal()];

        $media1 = $this->prophesize(MediaInterface::class);
        $media2 = $this->prophesize(MediaInterface::class);
        $mediaReference1 = $this->prophesize(ProductMediaReference::class);
        $mediaReference1->getMedia()->willReturn($media1->reveal());
        $mediaReference1->getType()->willReturn('test_type_1');
        $mediaReference2 = $this->prophesize(ProductMediaReference::class);
        $mediaReference2->getMedia()->willReturn($media2->reveal());
        $mediaReference2->getType()->willReturn('test_type_2');
        $mediaReferences = [$mediaReference1->reveal(), $mediaReference2->reveal()];

        $product = $this->prophesize(ProductInterface::class);
        $product->getId()->willReturn('123-123-123');
        $product->getCode()->willReturn('product-1');
        $product->getMainCategory()->willReturn($mainCategory->reveal());
        $product->getProductCategories()->willReturn($productCategories);
        $product->getMediaReferences()->willReturn($mediaReferences);

        $productInformation = $this->prophesize(ProductInformationInterface::class);
        $productInformation->getDimension()->willReturn($dimension->reveal());
        $productInformation->getProductId()->willReturn('123-123-123');
        $productInformation->getProductCode()->willReturn('product-1');
        $productInformation->getName()->willReturn('Product One');
        $product->findProductInformationByDimension($dimension->reveal())
            ->willReturn($productInformation->reveal());

        $contentView = $this->prophesize(ContentViewInterface::class);
        $contentView->getResourceKey()->willReturn(ProductInterface::RESOURCE_KEY);
        $contentView->getResourceId()->willReturn('123-123-123');
        $contentViewFactory->loadAndCreate(ProductInterface::RESOURCE_KEY, '123-123-123', [$dimension->reveal()])
            ->willReturn($contentView->reveal());

        $route = $this->prophesize(RouteInterface::class);
        $route->getPath()->willReturn('/test');
        $routable = $this->prophesize(RoutableResourceInterface::class);
        $routable->getRoute()->willReturn($route->reveal());
        $routableResourceRepository->findByResource(
            ProductInterface::RESOURCE_KEY,
            '123-123-123',
            $dimension->reveal()
        )->willReturn($routable->reveal());

        $mainCategoryApi = $this->prophesize(Category::class);

        $categoryApi1 = $this->prophesize(Category::class);
        $categoryApi2 = $this->prophesize(Category::class);

        $categoryManager->getApiObject($mainCategory->reveal(), 'de')->willReturn($mainCategoryApi->reveal());
        $categoryManager->getApiObjects($productCategories, 'de')
            ->willReturn([$categoryApi1->reveal(), $categoryApi2->reveal()]);

        $mediaApi1 = $this->prophesize(ApiMedia::class);
        $mediaApi2 = $this->prophesize(ApiMedia::class);

        $mediaManager->addFormatsAndUrl(
            Argument::that(function (ApiMedia $mediaApi) use ($media1) { return $mediaApi->getEntity() === $media1->reveal(); })
        )->willReturn($mediaApi1);
        $mediaManager->addFormatsAndUrl(
            Argument::that(function (ApiMedia $mediaApi) use ($media2) { return $mediaApi->getEntity() === $media2->reveal(); })
        )->willReturn($mediaApi2);

        $result = $factory->create($product->reveal(), [$dimension->reveal()]);

        $this->assertInstanceOf(ProductViewInterface::class, $result);
        $this->assertEquals($product->reveal(), $result->getProduct());
        $this->assertEquals($productInformation->reveal(), $result->getProductInformation());
        $this->assertEquals($mainCategoryApi->reveal(), $result->getMainCategory());
        $this->assertEquals([$categoryApi1->reveal(), $categoryApi2->reveal()], $result->getCategories());
        $this->assertEquals(
            [
                'test_type_1' => [$mediaApi1->reveal()],
                'test_type_2' => [$mediaApi2->reveal()],
            ],
            $result->getMedia()
        );
        $this->assertEquals($contentView->reveal(), $result->getContent());
        $this->assertEquals($routable->reveal(), $result->getRoutableResource());
    }
}
