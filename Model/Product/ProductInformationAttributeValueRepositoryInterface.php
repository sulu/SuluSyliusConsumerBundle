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

interface ProductInformationAttributeValueRepositoryInterface
{
    public function create(
        ProductInformationInterface $productInformation,
        string $code,
        string $type
    ): ProductInformationAttributeValueInterface;

    public function getTypeByCodes(array $codes): array;

    public function remove(ProductInformationAttributeValueInterface $productInformationAttributeValue): void;
}
