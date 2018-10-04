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
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\RoutableInterface;

class Product implements ProductInterface
{
    /**
     * @var DimensionInterface
     */
    private $dimension;

    /**
     * @var string
     */
    private $code;

    /**
     * @var Collection|ProductVariantInterface[]
     */
    private $variants;

    /**
     * @var ContentInterface
     */
    private $content;

    /**
     * @var RoutableInterface
     */
    private $routable;

    public function __construct(DimensionInterface $dimension, string $code, array $variants = [])
    {
        $this->dimension = $dimension;
        $this->code = $code;

        $this->variants = new ArrayCollection($variants);
    }

    public function getDimension(): DimensionInterface
    {
        return $this->dimension;
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

    public function setContent(ContentInterface $content): Product
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): ?ContentInterface
    {
        return $this->content;
    }

    public function setRoutable(RoutableInterface $routable): Product
    {
        $this->routable = $routable;

        return $this;
    }

    public function getRoutable(): ?RoutableInterface
    {
        return $this->routable;
    }
}
