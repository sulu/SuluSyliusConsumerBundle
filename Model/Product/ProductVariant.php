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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ProductVariant implements ProductVariantInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @var ProductVariantInformation[]|Collection
     */
    private $productVariantInformations;

    public function __construct(string $id, string $code, ProductInterface $product)
    {
        $this->id = $id;
        $this->code = $code;
        $this->product = $product;

        $this->productVariantInformations = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }
}
