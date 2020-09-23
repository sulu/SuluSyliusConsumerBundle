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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;

trait ProductTrait
{
    protected function createProduct(string $code): Product
    {
        $product = new Product(Uuid::uuid4()->toString(), $code);

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();

        return $product;
    }

    /**
     * @return Product|null
     */
    protected function findProduct(string $code): ?object
    {
        return $this->getEntityManager()->find(Product::class, $code);
    }

    /**
     * @return EntityManagerInterface
     */
    abstract protected function getEntityManager();
}
