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

    /**
     * @return ProductVariantInterface[]
     */
    public function getVariants(): array;

    public function findVariantByCode(string $code): ?ProductVariantInterface;

    public function addVariant(ProductVariantInterface $productVariant): self;

    public function removeVariant(ProductVariantInterface $productVariant): self;
}
