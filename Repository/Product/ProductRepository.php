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

namespace Sulu\Bundle\SyliusConsumerBundle\Repository\Product;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Ramsey\Uuid\Uuid;
use Sulu\Bundle\CategoryBundle\Entity\Category;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformation;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationAttributeValue;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class ProductRepository extends EntityRepository implements ProductRepositoryInterface
{
    public function create(string $code): ProductInterface
    {
        $className = $this->getClassName();
        $product = new $className(Uuid::uuid4()->toString(), $code);
        $this->getEntityManager()->persist($product);

        return $product;
    }

    public function findByCode(string $code): ?ProductInterface
    {
        /** @var ProductInterface $product */
        $product = $this->findOneBy(['code' => $code]);

        return $product;
    }

    public function findById(string $id): ?ProductInterface
    {
        /** @var ProductInterface $product */
        $product = $this->find($id);

        return $product;
    }

    public function searchCount(
        array $dimensions,
        array $categoryKeys = [],
        array $attributeFilters = [],
        string $query = null,
        array $queryFields = []
    ): int {
        $queryBuilder = $this->getSearchQueryBuilder(
            $dimensions,
            $categoryKeys,
            $attributeFilters,
            $query,
            $queryFields
        );

        $queryBuilder->select('COUNT(product.id)');

        $count = $queryBuilder->getQuery()->getSingleScalarResult();

        return intval($count);
    }

    public function search(
        array $dimensions,
        int $page,
        int $limit,
        array $categoryKeys = [],
        array $attributeFilters = [],
        string $query = null,
        array $queryFields = []
    ): array {
        $queryBuilder = $this->getSearchQueryBuilder(
            $dimensions,
            $categoryKeys,
            $attributeFilters,
            $query,
            $queryFields
        );

        $queryBuilder->select('product');
        $queryBuilder->addSelect('productInformation');
        $queryBuilder->addSelect('mainCategory');
        $queryBuilder->addSelect('categories');
        $queryBuilder->addSelect('mediaReferences');
        $queryBuilder->addSelect('attributeValues');

        $queryBuilder->leftJoin('product.mediaReferences', 'mediaReferences');

        $queryBuilder->setFirstResult(($page - 1) * $limit);
        $queryBuilder->setMaxResults($limit);

        return $queryBuilder->getQuery()->getResult();
    }

    protected function getSearchQueryBuilder(
        array $dimensions,
        array $categoryKeys = [],
        array $attributeFilters = [],
        string $query = null,
        array $queryFields = []
    ) {
        $dimensionIds = [];
        foreach ($dimensions as $dimension) {
            $dimensionIds[] = $dimension->getId();
        }

        $queryBuilder = $this->createQueryBuilder('product')
            ->leftJoin('product.productInformations', 'productInformation')
            ->where('IDENTITY(productInformation.dimension) IN(:dimensionIds)')
            ->setParameter('dimensionIds', $dimensionIds);

        $queryBuilder->leftJoin('productInformation.attributeValues', 'attributeValues');
        $queryBuilder->leftJoin('product.mainCategory', 'mainCategory');
        $queryBuilder->leftJoin('product.productCategories', 'categories');

        if ($categoryKeys) {
            $queryBuilder
                ->andWhere('mainCategory.key IN(:categoryKeys) OR categories.key IN(:categoryKeys)')
                ->setParameter('categoryKeys', $categoryKeys);
        }

        if ($query) {
            $expressions = $queryBuilder->expr()->orX();
            foreach ($queryFields as $queryField) {
                $expressions->add('LOWER(' . $queryField . ') LIKE :query');
            }

            $queryBuilder
                ->andWhere($expressions)
                ->setParameter('query', '%' . strtolower($query) . '%');
        }

        $this->addAttributesFilter($queryBuilder, $attributeFilters);

        return $queryBuilder;
    }

    protected function addAttributesFilter(QueryBuilder $queryBuilder, array $attributeFilters): void
    {
        foreach ($attributeFilters as $attributeFilter) {
            $code = $attributeFilter['code'];
            $value = $attributeFilter['value'];
            $type = $attributeFilter['type'];
            $propertyName = ProductInformationAttributeValue::getPropertyNameByType($type);

            $placeholderCode = $code . '_' . 'code';
            $placeholderValue = $code . '_' . 'value';

            $whereStatement = 'attributeValue.code = :' . $placeholderCode .
                ' AND attributeValue.' . $propertyName . ' = :' . $placeholderValue;

            $queryBuilder
                ->andWhere($whereStatement)
                ->setParameter($placeholderCode, $code)
                ->setParameter($placeholderValue, $value);
        }
    }

    public function remove(ProductInterface $product): void
    {
        $this->getEntityManager()->remove($product);
    }
}
