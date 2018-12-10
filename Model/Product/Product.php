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
use Doctrine\Common\Collections\Criteria;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

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
     * @var ProductMediaReference[]|Collection
     */
    private $mediaReferences;

    /**
     * @var ProductVariant[]|Collection
     */
    private $productVariants;

    /**
     * @var array
     */
    private $customData;

    /**
     * @var ProductInformation[]|Collection
     */
    private $productInformations;

    public function __construct(string $id, string $code)
    {
        $this->id = $id;
        $this->code = $code;

        $this->customData = [];
        $this->productCategories = new ArrayCollection();
        $this->mediaReferences = new ArrayCollection();
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

    public function findProductInformationByDimension(DimensionInterface $dimension): ?ProductInformationInterface
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('dimension', $dimension));
        $result = $this->productInformations->matching($criteria);

        if (0 === $result->count()) {
            return null;
        }

        return $result->first();
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

    public function findProductCategoryBySyliusId(int $syliusId): ?CategoryInterface
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('syliusId', $syliusId));
        $result = $this->productCategories->matching($criteria);

        if (0 === $result->count()) {
            return null;
        }

        return $result->first();
    }

    public function addProductCategory(CategoryInterface $productCategory): ProductInterface
    {
        $this->productCategories->add($productCategory);

        return $this;
    }

    public function removeProductCategory(CategoryInterface $productCategory): ProductInterface
    {
        $this->productCategories->removeElement($productCategory);

        return $this;
    }

    public function addMediaReference(ProductMediaReference $mediaReference): ProductInterface
    {
        $this->mediaReferences->add($mediaReference);

        return $this;
    }

    /**
     * @return ProductMediaReference[]
     */
    public function getMediaReferences(): array
    {
        $criteria = Criteria::create()->orderBy(['sorting' => Criteria::ASC]);
        $result = $this->mediaReferences->matching($criteria);

        return $result->getValues();
    }

    public function removeMediaReference(ProductMediaReference $mediaReference): ProductInterface
    {
        $this->mediaReferences->removeElement($mediaReference);

        return $this;
    }

    public function findMediaReferenceByMediaId(int $id): ?ProductMediaReference
    {
        foreach ($this->mediaReferences as $mediaReference) {
            if ($id === $mediaReference->getMediaId()) {
                return $mediaReference;
            }
        }

        return null;
    }

    public function getCustomData(): array
    {
        return $this->customData;
    }

    public function setCustomData(array $customData): ProductInterface
    {
        $this->customData = $customData;

        return $this;
    }
}
