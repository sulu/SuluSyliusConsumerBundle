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

use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryInterface;

interface ProductInterface
{
    const RESOURCE_KEY = 'products';

    public function __construct(string $id, string $code);

    public function getId(): string;

    public function getCode(): string;

    public function isEnabled(): bool;

    public function setEnabled(bool $enabled): self;

    /**
     * @return ProductInformationInterface[]
     */
    public function getProductInformations(): array;

    public function addProductInformation(ProductInformationInterface $productInformation): self;

    public function removeProductInformation(ProductInformationInterface $productInformation): self;

    /**
     * @return ProductVariantInterface[]
     */
    public function getVariants(): array;

    public function findVariantByCode(string $code): ?ProductVariantInterface;

    public function addVariant(ProductVariantInterface $productVariant): self;

    public function removeVariant(ProductVariantInterface $productVariant): self;

    public function getMainCategory(): ?CategoryInterface;

    public function setMainCategory(?CategoryInterface $mainCategory): self;

    /**
     * @return CategoryInterface[]
     */
    public function getProductCategories(): array;

    /**
     * @param CategoryInterface[] $productCategories
     */
    public function setProductCategories(array $productCategories): self;
}
