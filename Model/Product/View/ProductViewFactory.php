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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\View;

use Sulu\Bundle\CategoryBundle\Api\Category;
use Sulu\Bundle\CategoryBundle\Category\CategoryManagerInterface;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Exception\ContentNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductView;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\Exception\RoutableResourceNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceRepositoryInterface;

class ProductViewFactory implements ProductViewFactoryInterface
{
    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    /**
     * @var ProductInformationRepositoryInterface
     */
    private $productInformationRepository;

    /**
     * @var RoutableResourceRepositoryInterface
     */
    private $routableResourceRepository;

    /**
     * @var ContentViewFactoryInterface
     */
    private $contentViewFactory;

    /**
     * @var MediaManagerInterface
     */
    private $mediaManager;

    /**
     * @var CategoryManagerInterface
     */
    private $categoryManager;

    public function __construct(
        DimensionRepositoryInterface $dimensionRepository,
        ProductInformationRepositoryInterface $productInformationRepository,
        RoutableResourceRepositoryInterface $routableResourceRepository,
        ContentViewFactoryInterface $contentViewFactory,
        MediaManagerInterface $mediaManager,
        CategoryManagerInterface $categoryManager
    ) {
        $this->dimensionRepository = $dimensionRepository;
        $this->productInformationRepository = $productInformationRepository;
        $this->routableResourceRepository = $routableResourceRepository;
        $this->contentViewFactory = $contentViewFactory;
        $this->mediaManager = $mediaManager;
        $this->categoryManager = $categoryManager;
    }

    /**
     * @param DimensionInterface[] $dimensions
     */
    public function create(ProductInterface $product, array $dimensions): ProductViewInterface
    {
        $productInformation = null;
        $routableResource = null;
        $locale = null;

        foreach ($dimensions as $dimension) {
            if (null === $productInformation) {
                $productInformation = $this->productInformationRepository->findByProductId(
                    $product->getId(),
                    $dimension
                );
            }

            if (null === $routableResource) {
                $routableResource = $this->routableResourceRepository->findByResource(
                    ProductInterface::RESOURCE_KEY,
                    $product->getId(),
                    $dimension
                );
            }

            if (null === $locale && $dimension->hasAttribute(DimensionInterface::ATTRIBUTE_KEY_LOCALE)) {
                $locale = $dimension->getAttributeValue(DimensionInterface::ATTRIBUTE_KEY_LOCALE);
            }
        }
        if (null === $productInformation) {
            throw new ProductInformationNotFoundException($product->getCode());
        }
        if (null === $routableResource) {
            throw new RoutableResourceNotFoundException(ProductInterface::RESOURCE_KEY, $product->getId());
        }
        if (null === $locale) {
            throw new \InvalidArgumentException('No locale found');
        }

        $contentView = $this->contentViewFactory->loadAndCreate(
            ProductInterface::RESOURCE_KEY,
            $product->getId(),
            $dimensions
        );

        $viewProduct = new ProductView(
            $product->getId(),
            $locale,
            $product,
            $productInformation,
            $this->getMainCategory($product, $locale),
            $this->getCategories($product, $locale),
            $this->getMedia($product, $locale),
            $contentView,
            $routableResource
        );

        return $viewProduct;
    }

    protected function getMainCategory(ProductInterface $product, string $locale): ?Category
    {
        $mainCategory = $product->getMainCategory();
        if (!$mainCategory) {
            return null;
        }

        /** @var Category $mainCategoryApi */
        $mainCategoryApi = $this->categoryManager->getApiObject($mainCategory, $locale);

        return $mainCategoryApi;
    }

    protected function getCategories(ProductInterface $product, string $locale): array
    {
        /** @var Category[] $categories */
        $categories = $this->categoryManager->getApiObjects($product->getProductCategories(), $locale);

        return $categories;
    }

    /**
     * @return Media[][]
     */
    protected function getMedia(ProductInterface $product, string $locale): array
    {
        $media = [];
        foreach ($product->getMediaReferences() as $mediaReference) {
            $mediaApi = new Media($mediaReference->getMedia(), $locale);

            if (!array_key_exists($mediaReference->getType(), $media)) {
                $media[$mediaReference->getType()] = [];
            }

            $media[$mediaReference->getType()][] = $this->mediaManager->addFormatsAndUrl($mediaApi);
        }

        return $media;
    }
}
