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
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

class ProductInformation implements ProductInformationInterface
{
    /**
     * @var DimensionInterface
     */
    private $dimension;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $slug = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var string
     */
    private $metaKeywords = '';

    /**
     * @var string
     */
    private $metaDescription = '';

    /**
     * @var string
     */
    private $shortDescription = '';

    /**
     * @var string
     */
    private $unit = '';

    /**
     * @var string
     */
    private $marketingText = '';

    /**
     * @var Collection|ProductInformationVariantInterface[]
     */
    private $variants;

    /**
     * @var ProductInterface
     */
    private $product;

    public function __construct(ProductInterface $product, DimensionInterface $dimension, array $variants = [])
    {
        $this->dimension = $dimension;
        $this->product = $product;

        $this->variants = new ArrayCollection($variants);
    }

    public function getProductId(): string
    {
        return $this->product->getId();
    }

    public function getProductCode(): string
    {
        return $this->product->getCode();
    }

    public function getDimension(): DimensionInterface
    {
        return $this->dimension;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ProductInformationInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): ProductInformationInterface
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): ProductInformationInterface
    {
        $this->description = $description;

        return $this;
    }

    public function getMetaKeywords(): string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(string $metaKeywords): ProductInformationInterface
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    public function getMetaDescription(): string
    {
        return $this->metaKeywords;
    }

    public function setMetaDescription(string $metaDescription): ProductInformationInterface
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): ProductInformationInterface
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): ProductInformationInterface
    {
        $this->unit = $unit;

        return $this;
    }

    public function getMarketingText(): string
    {
        return $this->marketingText;
    }

    public function setMarketingText(string $marketingText): ProductInformationInterface
    {
        $this->marketingText = $marketingText;

        return $this;
    }

    public function getVariants(): array
    {
        return $this->variants->getValues();
    }

    public function findVariantByCode(string $code): ?ProductInformationVariantInterface
    {
        if (!$this->variants->containsKey($code)) {
            return null;
        }

        return $this->variants->get($code);
    }

    public function addVariant(ProductInformationVariantInterface $variant): ProductInformationInterface
    {
        $this->variants->set($variant->getCode(), $variant);

        return $this;
    }

    public function removeVariant(ProductInformationVariantInterface $variant): ProductInformationInterface
    {
        $this->variants->remove($variant->getCode());

        return $this;
    }
}
