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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindDraftProductQuery;

class FindDraftProductQueryHandler
{
    /**
     * @var ProductDataRepositoryInterface
     */
    private $productRepository;

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    public function __construct(
        ProductDataRepositoryInterface $productRepository,
        DimensionRepositoryInterface $dimensionRepository
    ) {
        $this->productRepository = $productRepository;
        $this->dimensionRepository = $dimensionRepository;
    }

    public function __invoke(FindDraftProductQuery $query): ProductDataInterface
    {
        $dimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $query->getLocale(),
            ]
        );

        $product = $this->productRepository->findByCode($query->getCode(), $dimension);
        if (!$product) {
            throw new ProductDataNotFoundException($query->getCode());
        }

        return $product;
    }
}
