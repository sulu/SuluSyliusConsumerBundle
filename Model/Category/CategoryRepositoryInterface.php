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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Category;

use Sulu\Bundle\CategoryBundle\Entity\CategoryRepositoryInterface as BaseCategoryRepositoryInterface;

interface CategoryRepositoryInterface extends BaseCategoryRepositoryInterface
{
    public function findBySyliusId(int $syliusId): ?CategoryInterface;

    public function findIdBySyliusId(int $syliusId): ?int;

    public function persist(CategoryInterface $category): void;
}
