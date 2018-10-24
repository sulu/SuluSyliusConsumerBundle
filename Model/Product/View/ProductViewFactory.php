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

    public function __construct(
        DimensionRepositoryInterface $dimensionRepository,
        ProductInformationRepositoryInterface $productInformationRepository,
        RoutableResourceRepositoryInterface $routableResourceRepository,
        ContentViewFactoryInterface $contentViewFactory
    ) {
        $this->dimensionRepository = $dimensionRepository;
        $this->productInformationRepository = $productInformationRepository;
        $this->routableResourceRepository = $routableResourceRepository;
        $this->contentViewFactory = $contentViewFactory;
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
            throw new ProductInformationNotFoundException($product->getId());
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

        $viewProduct = new ProductView($locale, $product, $productInformation, $content, $routableResource);

        return $viewProduct;
    }
}
