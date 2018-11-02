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

use JMS\Serializer\SerializerInterface;
use Sulu\Bundle\CategoryBundle\Api\Category;
use Sulu\Bundle\CategoryBundle\Category\CategoryManagerInterface;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Exception\ContentNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductView;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\Exception\RoutableResourceNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceRepositoryInterface;

class ProductViewFactory implements ProductViewFactoryInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

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
        SerializerInterface $serializer,
        DimensionRepositoryInterface $dimensionRepository,
        ProductInformationRepositoryInterface $productInformationRepository,
        RoutableResourceRepositoryInterface $routableResourceRepository,
        ContentViewFactoryInterface $contentViewFactory,
        MediaManagerInterface $mediaManager,
        CategoryManagerInterface $categoryManager
    ) {
        $this->serializer = $serializer;
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

        $content = $this->contentViewFactory->loadAndCreate(
            ProductInterface::RESOURCE_KEY,
            $product->getId(),
            $dimensions
        );
        if (null === $content) {
            throw new ContentNotFoundException(ProductInterface::RESOURCE_KEY, $product->getId());
        }

        $viewProduct = new ProductView(
            $product->getId(),
            $locale,
            $this->getProductData($product, $productInformation, $locale),
            $content,
            $routableResource
        );

        return $viewProduct;
    }

    protected function getProductData(
        ProductInterface $product,
        ProductInformationInterface $productInformation,
        string $locale)
    : array {
        $productData = array_merge(
            $this->serializer->serialize($product, 'array'),
            $this->serializer->serialize($productInformation, 'array')
        );

        $productData['mainCategory'] = $this->getMainCategory($product, $locale);
        $productData['categories'] = $this->categoryManager->getApiObjects($product->getProductCategories(), $locale);
        $productData['media'] = $this->getMedia($product, $locale);

        return $productData;
    }

    protected function getMainCategory(ProductInterface $product, string $locale): ?Category
    {
        if (!$product->getMainCategory()) {
            return null;
        }

        /** @var Category $mainCategory */
        $mainCategory = $this->categoryManager->getApiObject($product->getMainCategory(), $locale);

        return $mainCategory;
    }

    /**
     * @return Media[]
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
