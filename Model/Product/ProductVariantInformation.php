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

class ProductVariantInformation implements ProductVariantInformationInterface
{
    /**
     * @var ProductVariantInterface
     */
    private $productVariant;

    /**
     * @var DimensionInterface
     */
    private $dimension;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var array
     */
    private $additionalData;

    public function __construct(ProductVariantInterface $productVariant, DimensionInterface $dimension)
    {
        $this->productVariant = $productVariant;
        $this->dimension = $dimension;

        $this->additionalData = [];
    }

    public function getProductVariant(): ProductVariantInterface
    {
        return $this->productVariant;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ProductVariantInformationInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    public function setAdditionalData(array $additionalData): ProductVariantInformationInterface
    {
        $this->additionalData = $additionalData;

        return $this;
    }
}
