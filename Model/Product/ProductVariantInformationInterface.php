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

interface ProductVariantInformationInterface
{
    public function __construct(ProductVariantInterface $productVariant, DimensionInterface $dimension);

    public function getProductVariant(): ProductVariantInterface;

    public function getName(): string;

    public function setName(string $name): self;

    public function getAdditionalData(): array;

    public function setAdditionalData(array $additionalData): self;
}
