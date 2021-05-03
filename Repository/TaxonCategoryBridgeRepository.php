<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Repository;

use Sulu\Bundle\CategoryBundle\Entity\CategoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Entity\TaxonCategoryBridgeInterface;
use Sulu\Component\Persistence\Repository\ORM\EntityRepository;

class TaxonCategoryBridgeRepository extends EntityRepository implements TaxonCategoryBridgeRepositoryInterface
{
    public function create(int $id, CategoryInterface $category): TaxonCategoryBridgeInterface
    {
        $className = $this->getClassName();

        return new $className($id, $category);
    }

    public function add(TaxonCategoryBridgeInterface $bridge): void
    {
        $this->getEntityManager()->persist($bridge);
    }

    public function findById(int $id): ?TaxonCategoryBridgeInterface
    {
        return $this->find($id);
    }

    public function removeById(int $id): void
    {
        $this->getEntityManager()->remove($this->findById($id));
    }
}
