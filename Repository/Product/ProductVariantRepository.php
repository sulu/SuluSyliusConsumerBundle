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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;

class ProductVariantRepository extends EntityRepository implements ProductVariantRepositoryInterface
{
    public function create(ProductInterface $product, string $code): ProductVariantInterface
    {
        $className = $this->getClassName();
        $productVariant = new $className(Uuid::uuid4()->toString(), $code, $product);
        $this->getEntityManager()->persist($productVariant);
        $product->addVariant($productVariant);

        return $productVariant;
    }

    public function findByCode(string $code): ?ProductVariantInterface
    {
        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->findOneBy(['code' => $code]);

        return $productVariant;
    }

    public function findById(string $id): ?ProductVariantInterface
    {
        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->find($id);

        return $productVariant;
    }

    public function remove(ProductVariantInterface $productVariant): void
    {
        $this->getEntityManager()->remove($productVariant);
    }
}
