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

class ProductDataVariant implements ProductDataVariantInterface
{
    /**
     * @var ProductDataInterface
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

    public function __construct(ProductDataInterface $product, string $code)
    {
        $this->product = $product;
        $this->code = $code;
        $this->productCode = $product->getCode();
        $this->dimension = $product->getDimension();
    }

    public function getProduct(): ProductDataInterface
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

    public function setName(string $name): ProductDataVariantInterface
    {
        $this->name = $name;

        return $this;
    }
}
