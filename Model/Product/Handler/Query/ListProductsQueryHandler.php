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

    public function __invoke(ListProductsQuery $query): ListRepresentation
    {
        $fieldDescriptors = $this->getFieldDescriptors($query->getEntityClass());

        /** @var DoctrineListBuilder $listBuilder */
        $listBuilder = $this->listBuilderFactory->create($query->getEntityClass());
        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);
        $listBuilder->setIdField($fieldDescriptors['id']);

        $listBuilder->addSelectField($fieldDescriptors['id']);

        $listResponse = $listBuilder->execute();

        return new ListRepresentation(
            $listResponse,
            $query->getResourceKey(),
            $query->getRoute(),
            $query->getQuery(),
            $listBuilder->getCurrentPage(),
            $listBuilder->getLimit(),
            $listBuilder->count()
        );
    }

    /**
     * @return FieldDescriptor[]
     */
    protected function getFieldDescriptors(string $entityClass): array
    {
        /** @var FieldDescriptor[] $fieldDescriptors */
        $fieldDescriptors = $this->fieldDescriptorsFactory->getFieldDescriptorForClass($entityClass);

        return $fieldDescriptors;
    }
}
