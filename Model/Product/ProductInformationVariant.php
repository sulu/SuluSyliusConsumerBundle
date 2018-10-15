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

class ProductInformationVariant implements ProductInformationVariantInterface
{
    /**
     * @var ProductInformationInterface
     */
    private $product;

    /**
     * @var DimensionInterface
     */
    private $dimension;

    /**
     * @var string
     */
    private $productCode;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name = '';

    public function __construct(ProductInformationInterface $product, string $code)
    {
        $this->product = $product;
        $this->code = $code;
        $this->productCode = $product->getCode();
        $this->dimension = $product->getDimension();
    }

    public function getProduct(): ProductInformationInterface
    {
        return $this->product;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ProductInformationVariantInterface
    {
        $this->name = $name;

        return $this;
    }
}
