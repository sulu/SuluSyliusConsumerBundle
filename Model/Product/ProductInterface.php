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

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;

interface ProductInterface
{
    const RESOURCE_KEY = 'products';

    public function __construct(DimensionInterface $dimension, string $code, array $variants = []);

    public function getDimension(): DimensionInterface;

    public function getCode(): string;

    /**
     * @return ProductVariantInterface[]
     */
    public function getVariants(): array;

    public function findVariantByCode(string $code): ?ProductVariantInterface;

    public function addVariant(ProductVariantInterface $variant): self;

    public function removeVariant(ProductVariantInterface $variant): self;

    public function setContent(ContentInterface $content): Product;

    public function getContent(): ?ContentInterface;

    public function setRoutable(RoutableResourceInterface $routable): Product;

    public function getRoutable(): ?RoutableResourceInterface;
}
