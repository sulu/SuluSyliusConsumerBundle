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
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;

trait ProductTrait
{
    protected function createProduct(string $code): Product
    {
        $dimension = $this->findDimension(['workspace' => 'draft']);

        $product = new Product($dimension, $code);

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();

        return $product;
    }

    protected function findProduct(string $code): ?Product
    {
        $dimension = $this->findDimension(['workspace' => 'draft']);

        return $this->getEntityManager()->find(Product::class, ['code' => $code, 'dimension' => $dimension]);
    }

    abstract protected function findDimension(array $attributes): DimensionInterface;

    /**
     * @return EntityManagerInterface
     */
    abstract protected function getEntityManager();
}
