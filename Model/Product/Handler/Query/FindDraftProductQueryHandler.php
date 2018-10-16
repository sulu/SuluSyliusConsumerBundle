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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Exception\ProductInformationNotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\FindDraftProductQuery;

class FindDraftProductQueryHandler
{
    /**
     * @var ProductInformationRepositoryInterface
     */
    private $productRepository;

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    public function __construct(
        ProductInformationRepositoryInterface $productRepository,
        DimensionRepositoryInterface $dimensionRepository
    ) {
        $this->productRepository = $productRepository;
        $this->dimensionRepository = $dimensionRepository;
    }

    public function __invoke(FindDraftProductQuery $query): ProductInformationInterface
    {
        $dimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $query->getLocale(),
            ]
        );

        $product = $this->productRepository->findById($query->getId(), $dimension);
        if (!$product) {
            throw new ProductInformationNotFoundException($query->getId());
        }

        return $product;
    }
}
