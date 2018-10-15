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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformationRepositoryInterface;

class ProductInformationRepository extends EntityRepository implements ProductInformationRepositoryInterface
{
    public function create(string $code, DimensionInterface $dimension): ProductInformationInterface
    {
        $className = $this->getClassName();
        $product = new $className($code, $dimension);
        $this->getEntityManager()->persist($product);

        return $product;
    }

    public function findByCode(string $code, DimensionInterface $dimension): ?ProductInformationInterface
    {
        /** @var ProductInformationInterface $product */
        $product = $this->find(['code' => $code, 'dimension' => $dimension]);

        return $product;
    }

    public function remove(ProductInformationInterface $product): void
    {
        $this->getEntityManager()->remove($product);
    }

    /**
     * @return ProductInformationInterface[]
     */
    public function findAllByCode(string $code): array
    {
        return $this->findBy(['code' => $code]);
    }
}
