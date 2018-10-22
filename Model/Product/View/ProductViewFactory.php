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

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\View\ContentViewFactoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductView;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Repository\Product\ProductInformationRepository;

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

    public function create(ProductInterface $product, string $stage, string $locale): ProductViewInterface
    {
        $localizedDimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => $stage,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );
        $productInformation = $this->productInformationRepository->findByProductId(
            $product->getId(),
            $localizedDimension
        );

        $content = $this->contentViewFactory->create(
            ProductInterface::RESOURCE_KEY,
            $product->getId(),
            $stage,
            $locale
        );

        $routableResource = $this->routableResourceRepository->findOrCreateByResource(
            ProductInterface::RESOURCE_KEY,
            $product->getId(),
            $localizedDimension
        );

        $viewProduct = new ProductView($locale, $product, $productInformation, $content, $routableResource);

        return $viewProduct;
    }
}
