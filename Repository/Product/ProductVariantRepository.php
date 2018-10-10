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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariant;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantRepositoryInterface;

class ProductVariantRepository extends EntityRepository implements ProductVariantRepositoryInterface
{
    public function create(ProductInterface $product, string $code): ProductVariantInterface
    {
        $variant = new ProductVariant($product, $code);
        $product->addVariant($variant);
        $this->getEntityManager()->persist($variant);

        return $variant;
    }
}
