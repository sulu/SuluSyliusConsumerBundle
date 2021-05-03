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

interface TaxonCategoryBridgeRepositoryInterface
{
    public function create(int $id, CategoryInterface $category): TaxonCategoryBridgeInterface;

    public function add(TaxonCategoryBridgeInterface $bridge): void;

    public function findById(int $id): ?TaxonCategoryBridgeInterface;

    public function removeById(int $id): void;
}
