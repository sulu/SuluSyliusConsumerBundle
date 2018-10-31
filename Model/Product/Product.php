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
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryInterface;

class Product implements ProductInterface
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
     * @var bool
     */
    private $enabled = false;

    /**
     * @var CategoryInterface|null
     */
    private $mainCategory;

    /**
     * @var CategoryInterface[]|Collection
     */
    private $productCategories;

    /**
     * @var ProductVariant[]|Collection
     */
    private $productVariants;

    /**
     * @var ProductInformation[]|Collection
     */
    private $productInformations;

    public function __construct(string $id, string $code)
    {
        $this->id = $id;
        $this->code = $code;

        $this->productCategories = new ArrayCollection();
        $this->productVariants = new ArrayCollection();
        $this->productInformations = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): ProductInterface
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getVariants(): array
    {
        return $this->productVariants->getValues();
    }

    public function findVariantByCode(string $code): ?ProductVariantInterface
    {
        if (!$this->productVariants->containsKey($code)) {
            return null;
        }

        return $this->productVariants->get($code);
    }

    public function addVariant(ProductVariantInterface $productVariant): ProductInterface
    {
        $this->productVariants->set($productVariant->getCode(), $productVariant);

        return $this;
    }

    public function removeVariant(ProductVariantInterface $productVariant): ProductInterface
    {
        $this->productVariants->remove($productVariant->getCode());

        return $this;
    }

    public function getProductInformations(): array
    {
        return $this->productInformations->getValues();
    }

    public function addProductInformation(ProductInformationInterface $productInformation): ProductInterface
    {
        $this->productInformations->add($productInformation);

        return $this;
    }

    public function removeProductInformation(ProductInformationInterface $productInformation): ProductInterface
    {
        $this->productInformations->removeElement($productInformation);

        return $this;
    }

    public function getMainCategory(): ?CategoryInterface
    {
        return $this->mainCategory;
    }

    public function setMainCategory(?CategoryInterface $mainCategory): ProductInterface
    {
        $this->mainCategory = $mainCategory;

        return $this;
    }

    /**
     * @return CategoryInterface[]
     */
    public function getProductCategories(): array
    {
        return $this->productCategories->getValues();
    }

    /**
     * @param CategoryInterface[] $productCategories
     */
    public function setProductCategories(array $productCategories): ProductInterface
    {
        $this->productCategories->clear();

        foreach ($productCategories as $productCategory) {
            $this->productCategories->add($productCategory);
        }

        return $this;
    }
}
