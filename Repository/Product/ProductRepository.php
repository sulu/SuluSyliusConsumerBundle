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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductRepositoryInterface;

class ProductRepository extends EntityRepository implements ProductRepositoryInterface
{
    public function create(string $code): ProductInterface
    {
        $className = $this->getClassName();
        $product = new $className($code);
        $this->getEntityManager()->persist($product);

        return $product;
    }

    public function findByCode(string $code): ?ProductInterface
    {
        /** @var ProductInterface $product */
        $product = $this->find($code);

        return $product;
    }

    public function remove(ProductInterface $product): void
    {
        $this->getEntityManager()->remove($product);
    }
}
