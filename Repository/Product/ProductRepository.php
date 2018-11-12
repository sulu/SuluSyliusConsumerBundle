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
use Ramsey\Uuid\Uuid;
use Sulu\Bundle\CategoryBundle\Entity\Category;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformation;
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
        array $attributesFilter = [],
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

        foreach ($attributesFilter as $attributeId => $attributeValue) {
            $placeholderId = $attributeId . '_' . 'id';
            $placeholderValue = $attributeId . '_' . 'value';

            $queryBuilder
                ->join('productInformation.attributeValues', 'attributeValue')
                ->andWhere('attributeValue.code = :' . $placeholderId . ' AND attributeValue.textValue = :' . $placeholderValue)
                ->setParameter($placeholderId, $attributeId)
                ->setParameter($placeholderValue, $attributeValue);
        }

        if ($query) {
            $queryBuilder
                ->andWhere('LOWER(product.code) LIKE :query OR LOWER(productInformation.name) LIKE :query')
                ->setParameter('query', '%' . strtolower($query) . '%');
        }

        $queryBuilder->setFirstResult(($page - 1) * $pageSize);
        $queryBuilder->setMaxResults($pageSize);

        return $queryBuilder->getQuery()->getResult();
    }

    public function remove(ProductInterface $product): void
    {
        $this->getEntityManager()->remove($product);
    }
}
