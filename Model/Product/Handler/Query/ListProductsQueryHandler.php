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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\ListProductsQuery;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilder;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\FieldDescriptor;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\RestHelperInterface;

class ListProductsQueryHandler
{
    /**
     * @var DoctrineListBuilderFactoryInterface
     */
    private $listBuilderFactory;

    /**
     * @var RestHelperInterface
     */
    private $restHelper;

    /**
     * @var FieldDescriptorFactoryInterface
     */
    private $fieldDescriptorsFactory;

    public function __construct(
        DoctrineListBuilderFactoryInterface $listBuilderFactory,
        RestHelperInterface $restHelper,
        FieldDescriptorFactoryInterface $fieldDescriptorsFactory
    ) {
        $this->listBuilderFactory = $listBuilderFactory;
        $this->restHelper = $restHelper;
        $this->fieldDescriptorsFactory = $fieldDescriptorsFactory;
    }

    public function __invoke(ListProductsQuery $query): void
    {
        $fieldDescriptors = $this->getFieldDescriptors(Product::LIST_KEY);

        /** @var DoctrineListBuilder $listBuilder */
        $listBuilder = $this->listBuilderFactory->create(Product::class);
        $listBuilder->setParameter('keyLocale', DimensionInterface::ATTRIBUTE_KEY_LOCALE);
        $listBuilder->setParameter('keyStage', DimensionInterface::ATTRIBUTE_KEY_STAGE);
        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);
        $listBuilder->setIdField($fieldDescriptors['identifier']);

        $listBuilder->addSelectField($fieldDescriptors['id']);
        $listBuilder->sort($fieldDescriptors['id']);

        $listBuilder->where(
            $fieldDescriptors[DimensionInterface::ATTRIBUTE_KEY_STAGE],
            DimensionInterface::ATTRIBUTE_VALUE_DRAFT
        );
        $listBuilder->where(
            $fieldDescriptors[DimensionInterface::ATTRIBUTE_KEY_LOCALE],
            $query->getLocale()
        );

        if (array_key_exists('ids', $query->getQuery())) {
            $ids = explode(',', $query->getQuery()['ids']);
            $listBuilder->in($fieldDescriptors['id'], $ids);
        }

        $listBuilder->distinct();

        $listResponse = $listBuilder->execute();

        $products = new ListRepresentation(
            $listResponse,
            ProductInterface::RESOURCE_KEY,
            $query->getRoute(),
            $query->getQuery(),
            $listBuilder->getCurrentPage(),
            $listBuilder->getLimit(),
            $listBuilder->count()
        );
        $query->setProducts($products);
    }

    /**
     * @return FieldDescriptor[]
     */
    protected function getFieldDescriptors(string $formKey): array
    {
        /** @var FieldDescriptor[] $fieldDescriptors */
        $fieldDescriptors = $this->fieldDescriptorsFactory->getFieldDescriptors($formKey);

        return $fieldDescriptors;
    }
}
