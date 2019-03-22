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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Handler\Query;

use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindProductViewsQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactoryInterface;

class FindProductViewsQueryHandler
{
    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductViewFactoryInterface
     */
    private $productViewFactory;

    public function __construct(
        DimensionRepositoryInterface $dimensionRepository,
        ProductRepositoryInterface $productRepository,
        ProductViewFactoryInterface $productViewFactory
    ) {
        $this->dimensionRepository = $dimensionRepository;
        $this->productRepository = $productRepository;
        $this->productViewFactory = $productViewFactory;
    }

    public function __invoke(FindProductViewsQuery $query): void
    {
        $liveDimension = $this->dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE]
        );
        $localizedLiveDimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $query->getLocale(),
            ]
        );

        $products = $this->productRepository->findByIdsAndDimensionIds(
            $query->getIds(),
            [$liveDimension, $localizedLiveDimension]
        );

        $productViews = [];
        foreach ($products as $product) {
            $productViews[] = $this->productViewFactory->create($product, [$liveDimension, $localizedLiveDimension]);
        }

        $query->setProductViews($productViews);
    }
}
