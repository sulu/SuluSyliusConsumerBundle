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

class Product implements ProductInterface
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var Collection|ProductVariantInterface[]
     */
    private $variants;

    public function __construct(string $code, array $variants = [])
    {
        $this->code = $code;

        $this->variants = new ArrayCollection($variants);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getVariants(): array
    {
        return $this->variants->getValues();
    }

    public function findVariantByCode(string $code): ?ProductVariantInterface
    {
        if (!$this->variants->containsKey($code)) {
            return null;
        }

        return $this->variants->get($code);
    }

    public function addVariant(ProductVariantInterface $variant): ProductInterface
    {
        $this->variants->set($variant->getCode(), $variant);

        return $this;
    }

    public function removeVariant(ProductVariantInterface $variant): ProductInterface
    {
        $this->variants->remove($variant->getCode());

        return $this;
    }
}
