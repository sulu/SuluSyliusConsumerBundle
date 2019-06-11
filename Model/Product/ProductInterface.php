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
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

interface ProductInterface
{
    const RESOURCE_KEY = 'products';
    const FORM_KEY = 'product_details';
    const LIST_KEY = 'product_details';
    const CONTENT_RESOURCE_KEY = 'product_content';
    const CONTENT_FORM_KEY = 'product_content';

    public function getId(): string;

    public function getCode(): string;

    public function isEnabled(): bool;

    public function setEnabled(bool $enabled): self;

    /**
     * @return ProductInformationInterface[]
     */
    public function getProductInformations(): array;

    public function findProductInformationByDimension(DimensionInterface $dimension): ?ProductInformationInterface;

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

    public function findProductCategoryBySyliusId(int $id): ?CategoryInterface;

    public function addProductCategory(CategoryInterface $productCategory): ProductInterface;

    public function removeProductCategory(CategoryInterface $productCategory): ProductInterface;

    public function addMediaReference(ProductMediaReference $mediaReference): ProductInterface;

    /**
     * @return ProductMediaReference[]
     */
    public function getMediaReferences(): array;

    public function removeMediaReference(ProductMediaReference $mediaReference): ProductInterface;

    public function findMediaReferenceByMediaId(int $id): ?ProductMediaReference;

    public function getCustomData(): array;

    public function setCustomData(array $customData): self;
}
