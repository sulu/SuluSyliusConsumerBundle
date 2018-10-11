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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataVariantInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductDataVariantRepositoryInterface;

class ProductDataVariantRepository extends EntityRepository implements ProductDataVariantRepositoryInterface
{
    public function create(ProductDataInterface $product, string $code): ProductDataVariantInterface
    {
        $className = $this->getClassName();
        $variant = new $className($product, $code);
        $product->addVariant($variant);
        $this->getEntityManager()->persist($variant);

        return $variant;
    }
}
