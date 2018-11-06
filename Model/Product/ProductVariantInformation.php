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
    private $customData;

    public function __construct(ProductVariantInterface $productVariant, DimensionInterface $dimension)
    {
        $this->productVariant = $productVariant;
        $this->dimension = $dimension;

        $this->customData = [];
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

    public function getCustomData(): array
    {
        return $this->customData;
    }

    public function setCustomData(array $customData): ProductVariantInformationInterface
    {
        $this->customData = $customData;

        return $this;
    }
}
