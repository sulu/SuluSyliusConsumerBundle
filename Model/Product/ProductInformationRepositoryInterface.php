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

    public function findByProductId(string $productId, DimensionInterface $dimension): ?ProductInformationInterface;

    public function findByProductIdAndDimensions(string $productId, array $dimensions): array;

    /**
     * @return ProductInformationInterface[]
     */
    public function findAllByProductId(string $productId): array;

    public function remove(ProductInformationInterface $productInformation): void;
}
