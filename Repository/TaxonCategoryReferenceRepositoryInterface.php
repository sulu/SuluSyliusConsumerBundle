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

interface TaxonCategoryReferenceRepositoryInterface
{
    public function create(int $id, CategoryInterface $category): TaxonCategoryReferenceInterface;

    public function add(TaxonCategoryReferenceInterface $reference): void;

    public function findById(int $id): ?TaxonCategoryReferenceInterface;

    public function removeById(int $id): void;
}
