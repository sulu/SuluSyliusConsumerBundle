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
use Doctrine\ORM\NoResultException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;

class ProductInformationRepository extends EntityRepository implements ProductInformationRepositoryInterface
{
    public function create(ProductInterface $product, DimensionInterface $dimension): ProductInformationInterface
    {
        $className = $this->getClassName();
        $productInformation = new $className($product, $dimension);
        $this->getEntityManager()->persist($productInformation);

        return $productInformation;
    }

    public function findByProductId(string $productId, DimensionInterface $dimension): ?ProductInformationInterface
    {
        $queryBuilder = $this->createQueryBuilder('product_information')
            ->addSelect('product')
            ->join('product_information.product', 'product')
            ->where('product.id = :productId')
            ->andWhere('IDENTITY(product_information.dimension) = :dimensionId')
            ->setParameter('productId', $productId)
            ->setParameter('dimensionId', $dimension->getId());

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * @return ProductInformationInterface[]
     */
    public function findAllByProductId(string $productId): array
    {
        return $this->findBy(['product' => $productId]);
    }

    public function remove(ProductInformationInterface $productInformation): void
    {
        $this->getEntityManager()->remove($productInformation);
    }
}
