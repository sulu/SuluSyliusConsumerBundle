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

use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

interface ProductInformationRepositoryInterface
{
    public function create(ProductInterface $product, DimensionInterface $dimension): ProductInformationInterface;

    public function findByCode(string $code, DimensionInterface $dimension): ?ProductInformationInterface;

    public function findById(string $id, DimensionInterface $dimension): ?ProductInformationInterface;

    /**
     * @return ProductInformationInterface[]
     */
    public function findAllById(string $id): array;

    public function remove(ProductInformationInterface $product): void;
}
