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

use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindPublishedProductQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactoryInterface;

class FindPublishedProductQueryHandler
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    /**
     * @var ProductViewFactoryInterface
     */
    private $productViewFactory;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        DimensionRepositoryInterface $dimensionRepository,
        ProductViewFactoryInterface $productViewFactory
    ) {
        $this->productRepository = $productRepository;
        $this->dimensionRepository = $dimensionRepository;
        $this->productViewFactory = $productViewFactory;
    }

    public function __invoke(FindPublishedProductQuery $query): ProductInterface
    {
        $dimension = $this->dimensionRepository->findOrCreateByAttributes(
            ['workspace' => 'live']
        );
        $localizedDimension = $this->dimensionRepository->findOrCreateByAttributes(
            ['workspace' => 'live', 'locale' => $query->getLocale()]
        );

        $product = $this->productRepository->findByCode($dimension, $query->getCode());
        if (!$product) {
            throw new ProductNotFoundException($query->getCode());
        }

        return $this->productViewFactory->create([$product], [$dimension, $localizedDimension]);
    }
}
