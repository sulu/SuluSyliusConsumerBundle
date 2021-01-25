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

namespace Sulu\Bundle\SyliusConsumerBundle\Repository;

use Sulu\Bundle\CategoryBundle\Entity\CategoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Entity\TaxonCategoryReferenceInterface;
use Sulu\Component\Persistence\Repository\ORM\EntityRepository;

class TaxonCategoryReferenceRepository extends EntityRepository implements TaxonCategoryReferenceRepositoryInterface
{
    public function create(int $id, CategoryInterface $category): TaxonCategoryReferenceInterface
    {
        $className = $this->getClassName();

        return new $className($id, $category);
    }

    public function add(TaxonCategoryReferenceInterface $reference): void
    {
        $this->getEntityManager()->persist($reference);
    }

    public function findById(int $id): ?TaxonCategoryReferenceInterface
    {
        return $this->find($id);
    }

    public function removeById(int $id): void
    {
        $this->getEntityManager()->remove($this->findById($id));
    }
}
