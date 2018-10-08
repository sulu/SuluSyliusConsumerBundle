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

class ProductVariant implements ProductVariantInterface
{
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @var string
     */
    private $code;

    public function __construct(ProductInterface $product, string $code)
    {
        $this->product = $product;
        $this->code = $code;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
