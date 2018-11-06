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

interface ProductVariantInterface
{
    public function __construct(string $id, string $code, ProductInterface $product);

    public function getId(): string;

    public function getProduct(): ProductInterface;

    public function getCode(): string;

    public function getCustomData(): array;

    public function setCustomData(array $customData): self;
}
