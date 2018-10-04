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
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class ProductRepository extends EntityRepository implements ProductRepositoryInterface
{
    public function create(DimensionInterface $dimension, string $code): ProductInterface
    {
        $className = $this->getClassName();
        $product = new $className($dimension, $code);
        $this->getEntityManager()->persist($product);

        return $product;
    }

    public function findByCode(DimensionInterface $dimension, string $code): ?ProductInterface
    {
        /** @var ProductInterface $product */
        $product = $this->find(['code' => $code, 'dimension' => $dimension]);

        return $product;
    }

    public function remove(ProductInterface $product): void
    {
        $this->getEntityManager()->remove($product);
    }

    /**
     * @return ProductInterface[]
     */
    public function findAllByCode(string $code): array
    {
        return $this->findBy(['code' => $code]);
    }
}
