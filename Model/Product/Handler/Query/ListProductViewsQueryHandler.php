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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationAttributeValueRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewList;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewListInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\ListProductViewsQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactoryInterface;

class ListProductViewsQueryHandler
{
    const DEFAULT_LIMIT = 10;
    const DEFAULT_QUERY_FIELDS = ['product.code', 'productInformation.name'];

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductInformationAttributeValueRepositoryInterface
     */
    private $productInformationAttributeValueRepository;

    /**
     * @var ProductViewFactoryInterface
     */
    private $productViewFactory;

    public function __construct(
        DimensionRepositoryInterface $dimensionRepository,
        ProductRepositoryInterface $productRepository,
        ProductInformationAttributeValueRepositoryInterface $productInformationAttributeValueRepository,
        ProductViewFactoryInterface $productViewFactory
    ) {
        $this->dimensionRepository = $dimensionRepository;
        $this->productRepository = $productRepository;
        $this->productInformationAttributeValueRepository = $productInformationAttributeValueRepository;
        $this->productViewFactory = $productViewFactory;
    }

    public function __invoke(ListProductViewsQuery $query): ProductViewListInterface
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

        $page = $query->getPage() ?: 1;
        $limit = $query->getLimit() ?: self::DEFAULT_LIMIT;
        $queryFields = $query->getQueryFields() ?: self::DEFAULT_QUERY_FIELDS;
        $attributeFilters = $this->getAttributeFilters($query);

        $dimensions = [$liveDimension, $localizedLiveDimension];

        $total = $this->productRepository->searchCount(
            $dimensions,
            $query->getCategoryKeys(),
            $attributeFilters,
            $query->getQuery(),
            $queryFields
        );

        $products = $this->productRepository->search(
            $dimensions,
            $page,
            $limit,
            $query->getCategoryKeys(),
            $attributeFilters,
            $query->getQuery(),
            $queryFields
        );

        $productViews = [];
        foreach ($products as $product) {
            $productViews[] = $this->productViewFactory->create($product, [$liveDimension, $localizedLiveDimension]);
        }

        return new ProductViewList(
            $page,
            $limit,
            $total,
            $productViews
        );
    }

    private function getAttributeFilters(ListProductViewsQuery $query): array
    {
        $attributeFilters = [];
        $types = $this->productInformationAttributeValueRepository->getTypeByCodes(
            array_keys($query->getAttributeFilters())
        );
        foreach ($query->getAttributeFilters() as $attributeCode => $attributeValue) {
            if (!in_array($attributeCode, $types)) {
                throw new \RuntimeException('No type for attribute with code "' . $attributeCode . '" found');
            }

            $attributeFilters[] = [
                'code' => $attributeCode,
                'value' => $attributeValue,
                'type' => $types[$attributeCode],
            ];
        }

        return $attributeFilters;
    }
}
