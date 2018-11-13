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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
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

    public function search(
        array $dimensions,
        int $page,
        int $pageSize,
        array $categoryKeys = [],
        array $attributeFilters = [],
        string $query = null
    ): array {
        $dimensionIds = [];
        foreach ($dimensions as $dimension) {
            $dimensionIds[] = $dimension->getId();
        }

        $queryBuilder = $this->createQueryBuilder('product')
            ->select('product')
            ->join(ProductInformation::class, 'productInformation', 'WITH', 'product.id = productInformation.product')
            ->where('IDENTITY(productInformation.dimension) IN(:dimensionIds)')
            ->setParameter('dimensionIds', $dimensionIds);

        if ($categoryKeys) {
            $queryBuilder
                ->join('product.mainCategory', 'mainCategory')
                ->join(Category::class, 'category')
                ->andWhere('mainCategory.key IN(:categoryKeys) OR category.key IN(:categoryKeys)')
                ->setParameter('categoryKeys', $categoryKeys);
        }

        if ($query) {
            $queryBuilder
                ->andWhere('LOWER(product.code) LIKE :query OR LOWER(productInformation.name) LIKE :query')
                ->setParameter('query', '%' . strtolower($query) . '%');
        }

        $this->addAttributesFilter($queryBuilder, $attributeFilters);

        $queryBuilder->setFirstResult(($page - 1) * $pageSize);
        $queryBuilder->setMaxResults($pageSize);

        return $queryBuilder->getQuery()->getResult();
    }

    protected function addAttributesFilter(QueryBuilder $queryBuilder, array $attributeFilters): void
    {
        foreach ($attributeFilters as $attributeFilter) {
            $code = $attributeFilter['code'];
            $value = $attributeFilter['value'];
            $type = $attributeFilter['type'];
            $propertyName = ProductInformationAttributeValue::getGetterByType($type);

            $placeholderCode = $code . '_' . 'code';
            $placeholderValue = $code . '_' . 'value';

            $whereStatement = 'attributeValue.code = :' . $placeholderCode .
                ' AND attributeValue.' . $propertyName . ' = :' . $placeholderValue;

            $queryBuilder
                ->join('productInformation.attributeValues', 'attributeValue')
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
