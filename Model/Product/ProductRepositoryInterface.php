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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product;

interface ProductRepositoryInterface
{
    public function create(string $code): ProductInterface;

    public function findByCode(string $code): ?ProductInterface;

    public function findById(string $id): ?ProductInterface;

    public function searchCount(
        array $dimensions,
        array $categoryKeys = [],
        array $attributeFilters = [],
        string $query = null,
        array $queryFields = []
    ): int;

    /**
     * @return ProductInterface[]
     */
    public function search(
        array $dimensions,
        int $page,
        int $limit,
        array $categoryKeys = [],
        array $attributeFilters = [],
        string $query = null,
        array $queryFields = []
    ): array;

    /**
     * @return ProductInterface[]
     */
    public function findByIdsAndDimensionIds(array $ids, array $dimensionIds): array;

    public function remove(ProductInterface $product): void;
}
