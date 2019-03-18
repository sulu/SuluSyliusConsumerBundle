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

use Sulu\Bundle\SyliusConsumerBundle\Model\Attribute\Query\FindAttributeTranslationsByCodesQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationAttributeValueRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewList;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\ListProductViewsQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\View\ProductViewFactoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ListProductViewsQueryHandler
{
    const DEFAULT_LIMIT = 10;
    const DEFAULT_QUERY_FIELDS = ['product.code', 'productInformation.name'];

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

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
        MessageBusInterface $messageBus,
        DimensionRepositoryInterface $dimensionRepository,
        ProductRepositoryInterface $productRepository,
        ProductInformationAttributeValueRepositoryInterface $productInformationAttributeValueRepository,
        ProductViewFactoryInterface $productViewFactory
    ) {
        $this->messageBus = $messageBus;
        $this->dimensionRepository = $dimensionRepository;
        $this->productRepository = $productRepository;
        $this->productInformationAttributeValueRepository = $productInformationAttributeValueRepository;
        $this->productViewFactory = $productViewFactory;
    }

    public function __invoke(ListProductViewsQuery $query): void
    {
        $locale = $query->getLocale();

        $liveDimension = $this->dimensionRepository->findOrCreateByAttributes(
            [DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE]
        );
        $localizedLiveDimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
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
        $attributeCodes = [];
        foreach ($products as $product) {
            $productView = $this->productViewFactory->create($product, [$liveDimension, $localizedLiveDimension]);

            $attributeCodes = array_merge(
                $attributeCodes,
                $productView->getProductInformation()->getAttributeValueCodes()
            );

            $productViews[] = $productView;
        }

        $productAttributeTranslations = [];
        if ($query->loadAttributeTranslations() && $attributeCodes) {
            $message = new FindAttributeTranslationsByCodesQuery($locale, $attributeCodes);
            $this->messageBus->dispatch($message);
            $productAttributeTranslations = $message->getProductAttributeTranslations();
        }

        $productViewList = new ProductViewList(
            $page,
            $limit,
            $total,
            $productViews,
            $productAttributeTranslations
        );
        $query->setProductViewList($productViewList);
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
