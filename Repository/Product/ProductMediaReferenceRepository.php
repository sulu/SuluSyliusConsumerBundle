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
use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReference;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductMediaReferenceRepositoryInterface;

class ProductMediaReferenceRepository extends EntityRepository implements ProductMediaReferenceRepositoryInterface
{
    public function create(ProductInterface $product, MediaInterface $media, string $type, ?int $syliusId = null): ProductMediaReference
    {
        $className = $this->getClassName();
        $mediaReference = new $className($product, $media, $type, $syliusId);
        $this->getEntityManager()->persist($mediaReference);

        return $mediaReference;
    }

    public function findBySyliusId(int $syliusId): ?ProductMediaReference
    {
        /** @var ProductMediaReference $mediaReference */
        $mediaReference = $this->findOneBy(['syliusId' => $syliusId]);

        return $mediaReference;
    }

    public function remove(ProductMediaReference $mediaReference): void
    {
        $this->getEntityManager()->remove($mediaReference);
    }
}
