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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationAttributeValue;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Repository\FindScheduldedEntityInsertionTrait;

class ProductRepository extends EntityRepository implements ProductRepositoryInterface
{
    use FindScheduldedEntityInsertionTrait;

    public function create(string $code): ProductInterface
    {
        $className = $this->getClassName();
        $product = new $className(Uuid::uuid4()->toString(), $code);
        $this->getEntityManager()->persist($product);

        return $product;
    }

    public function findByCode(string $code): ?ProductInterface
    {
        /** @var ProductInterface|null $product */
        $product = $this->findOneBy(['code' => $code]);

        if (!$product) {
            /** @var ProductInterface|null $product */
            $product = $this->findScheduldedEntityInsertion(function (ProductInterface $product) use ($code) {
                return $code === $product->getCode();
            });
        }

        return $product;
    }

    public function findById(string $id): ?ProductInterface
    {
        /** @var ProductInterface $product */
        $product = $this->find($id);

        return $product;
    }

    public function findByIdsAndDimensionIds(array $ids, array $dimensionIds): array
    {
        $queryBuilder = $this->createQueryBuilder('product')
            ->innerJoin('product.productInformations', 'productInformation', 'WITH', 'productInformation.dimension IN(:dimensionIds)')
            ->where('product.id IN(:ids)')
            ->setParameter('ids', $ids)
            ->setParameter('dimensionIds', $dimensionIds);

        $queryBuilder->leftJoin('productInformation.attributeValues', 'attributeValues');
        $queryBuilder->leftJoin('product.mainCategory', 'mainCategory');
        $queryBuilder->leftJoin('product.productCategories', 'categories');
        $queryBuilder->leftJoin('product.mediaReferences', 'mediaReferences');

        $queryBuilder->select('product');
        $queryBuilder->addSelect('productInformation');
        $queryBuilder->addSelect('mainCategory');
        $queryBuilder->addSelect('categories');
        $queryBuilder->addSelect('mediaReferences');
        $queryBuilder->addSelect('attributeValues');

        /** @var ProductInterface[] $products */
        $products = $queryBuilder->getQuery()->getResult();

        return $products;
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

        $queryBuilder->select('COUNT(DISTINCT product.id)');

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

        $queryBuilder->select('product.id');
        $queryBuilder->groupBy('product.id');

        $queryBuilder->setFirstResult(($page - 1) * $limit);
        $queryBuilder->setMaxResults($limit);

        $ids = array_column($queryBuilder->getQuery()->getArrayResult(), 'id');

        return $this->findByIdsAndDimensionIds($ids, $dimensions);
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
            ->innerJoin('product.productInformations', 'productInformation', 'WITH', 'productInformation.dimension IN(:dimensionIds)')
            ->setParameter('dimensionIds', $dimensionIds);

        if ($categoryKeys) {
            $queryBuilder
                ->leftJoin('product.mainCategory', 'mainCategory')
                ->leftJoin('product.productCategories', 'categories')
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
                ->leftJoin('productInformation.attributeValues', 'attributeValues')
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
