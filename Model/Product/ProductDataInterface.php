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

interface ProductDataInterface
{
    public function __construct(string $code, DimensionInterface $dimension, array $variants = []);

    public function getCode(): string;

    public function getDimension(): DimensionInterface;

    public function getName(): string;

    public function setName(string $name): self;

    /**
     * @return ProductDataVariantInterface[]
     */
    public function getVariants(): array;

    public function findVariantByCode(string $code): ?ProductDataVariantInterface;

    public function addVariant(ProductDataVariantInterface $variant): self;

    public function removeVariant(ProductDataVariantInterface $variant): self;
}
