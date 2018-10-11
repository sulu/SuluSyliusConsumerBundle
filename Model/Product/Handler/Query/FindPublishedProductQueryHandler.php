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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductDataNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindPublishedProductQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactoryInterface;

class FindPublishedProductQueryHandler
{
    /**
     * @var ProductDataRepositoryInterface
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
        ProductDataRepositoryInterface $productRepository,
        DimensionRepositoryInterface $dimensionRepository,
        ProductViewFactoryInterface $productViewFactory
    ) {
        $this->productRepository = $productRepository;
        $this->dimensionRepository = $dimensionRepository;
        $this->productViewFactory = $productViewFactory;
    }

    public function __invoke(FindPublishedProductQuery $query): ProductViewInterface
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

        $product = $this->productRepository->findByCode($query->getCode(), $localizedLiveDimension);
        if (!$product) {
            throw new ProductDataNotFoundException($query->getCode());
        }

        return $this->productViewFactory->create($product, [$liveDimension, $localizedLiveDimension]);
    }
}
