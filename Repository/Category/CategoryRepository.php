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

namespace Sulu\Bundle\SyliusConsumerBundle\Repository\Category;

use Sulu\Bundle\CategoryBundle\Entity\CategoryRepository as BaseCategoryRepository;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryRepositoryInterface;

class CategoryRepository extends BaseCategoryRepository implements CategoryRepositoryInterface
{
    public function findBySyliusId(int $syliusId): ?CategoryInterface
    {
        /** @var CategoryInterface $category */
        $category = $this->findOneBy(['syliusId' => $syliusId]);

        return $category;
    }

    public function persist(CategoryInterface $category): void
    {
        $this->getEntityManager()->persist($category);
    }
}
