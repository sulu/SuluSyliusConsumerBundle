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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInformationRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;

class ProductVariantInformationRepository extends EntityRepository implements ProductVariantInformationRepositoryInterface
{
    public function create(ProductVariantInterface $productVariant, DimensionInterface $dimension): ProductVariantInformationInterface
    {
        $className = $this->getClassName();
        $productVariantInformation = new $className($productVariant, $dimension);
        $this->getEntityManager()->persist($productVariantInformation);

        return $productVariantInformation;
    }

    public function findByVariantId(string $variantId, DimensionInterface $dimension): ?ProductVariantInformationInterface
    {
        $queryBuilder = $this->createQueryBuilder('product_variant_information')
            ->addSelect('productVariant')
            ->join('product_variant_information.productVariant', 'productVariant')
            ->where('productVariant.id = :variantId')
            ->andWhere('IDENTITY(product_variant_information.dimension) = :dimensionId')
            ->setParameter('variantId', $variantId)
            ->setParameter('dimensionId', $dimension->getId());

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    public function findAllByVariantId(string $variantId): array
    {
        return $this->findBy(['productVariant' => $variantId]);
    }

    public function remove(ProductVariantInformationInterface $variantInformation): void
    {
        $this->getEntityManager()->remove($variantInformation);
    }
}
