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

interface ProductInformationInterface
{
    public function __construct(ProductInterface $product, DimensionInterface $dimension, array $variants = []);

    public function getProductId(): string;

    public function getProductCode(): string;

    public function getDimension(): DimensionInterface;

    public function getName(): string;
    public function setName(string $name): self;

    public function getSlug(): string;
    public function setSlug(string $slug): self;

    public function getDescription(): string;
    public function setDescription(string $description): self;

    public function getMetaKeywords(): string;
    public function setMetaKeywords(string $metaKeywords): self;

    public function getMetaDescription(): string;
    public function setMetaDescription(string $metaDescription): self;

    public function getShortDescription(): string;
    public function setShortDescription(string $shortDescription): self;

    public function getUnit(): string;
    public function setUnit(string $unit): self;

    public function getMarketingText(): string;
    public function setMarketingText(string $marketingText): self;

    /**
     * @return ProductInformationVariantInterface[]
     */
    public function getVariants(): array;

    public function findVariantByCode(string $code): ?ProductInformationVariantInterface;

    public function addVariant(ProductInformationVariantInterface $variant): self;

    public function removeVariant(ProductInformationVariantInterface $variant): self;
}
