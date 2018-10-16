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
        $product = new $className($product, $dimension);
        $this->getEntityManager()->persist($product);

        return $product;
    }

    public function findByCode(string $code, DimensionInterface $dimension): ?ProductInformationInterface
    {
        /** @var ProductInformationInterface $product */
        $product = $this->findOneBy(['code' => $code, 'dimension' => $dimension]);

        return $product;
    }

    public function findById(string $id, DimensionInterface $dimension): ?ProductInformationInterface
    {
        $queryBuilder = $this->createQueryBuilder('product_information')
            ->addSelect('product')
            ->join('product_information.product', 'product')
            ->where('product.id = :id')
            ->andWhere('IDENTITY(product_information.dimension) = :dimensionId')
            ->setParameter('id', $id)
            ->setParameter('dimensionId', $dimension->getId());

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }

        /** @var ProductInformationInterface $product */
        $product = $this->find(['product' => $id, 'dimension' => $dimension]);

        return $product;
    }

    public function remove(ProductInformationInterface $product): void
    {
        $this->getEntityManager()->remove($product);
    }

    /**
     * @return ProductInformationInterface[]
     */
    public function findAllById(string $id): array
    {
        return $this->findBy(['product' => $id]);
    }
}
