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
    public function __construct(ProductInterface $product, DimensionInterface $dimension);

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

    public function mapPublishProperties(self $draft): void;

    public function getCustomData(): array;

    public function setCustomData(array $customData): self;

    /**
     * @param ProductInformationAttributeValueInterface[] $attributeValues
     */
    public function setAttributeValues(array $attributeValues): self;

    /**
     * @return ProductInformationAttributeValueInterface[]
     */
    public function getAttributeValues(): array;

    /**
     * @return string[]
     */
    public function getAttributeValueCodes(): array;

    public function addAttributeValue(ProductInformationAttributeValueInterface $attributeValue): self;

    public function findAttributeValueByCode(string $code): ?ProductInformationAttributeValueInterface;

    public function removeAttributeValue(ProductInformationAttributeValueInterface $attributeValue): self;

    public function removeAttributeValueByCode(string $code): self;
}
