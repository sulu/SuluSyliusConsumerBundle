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
     * @var array
     */
    private $customData;

    /**
     * @var ProductInformationAttributeValueInterface[]|Collection
     */
    private $attributeValues;

    /**
     * @var ProductInterface
     */
    private $product;

    public function __construct(ProductInterface $product, DimensionInterface $dimension)
    {
        $this->dimension = $dimension;
        $this->product = $product;

        $this->customData = [];
        $this->attributeValues = new ArrayCollection();
    }

    public function getProductId(): string
    {
        return $this->product->getId();
    }

    public function getProductCode(): string
    {
        return $this->product->getCode();
    }

    public function getMediaReferences(): array
    {
        return $this->product->getMediaReferences();
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

    public function mapPublishProperties(ProductInformationInterface $draft): void
    {
        $setters = array_filter(get_class_methods($this), function ($method) {
            return 0 === strpos($method, 'set');
        });

        foreach ($setters as $setter) {
            $getter = str_replace('set', 'get', $setter);

            if (method_exists($draft, $getter)) {
                $this->$setter($draft->$getter());
            }
        }
    }

    public function getCustomData(): array
    {
        return $this->customData;
    }

    public function setCustomData(array $customData): ProductInformationInterface
    {
        $this->customData = $customData;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeValues(): array
    {
        return $this->attributeValues->getValues();
    }

    public function addAttributeValue(ProductInformationAttributeValueInterface $attributeValue): ProductInformationInterface
    {
        $this->attributeValues->set($attributeValue->getCode(), $attributeValue);

        return $this;
    }

    public function removeAttributeValue(ProductInformationAttributeValueInterface $attributeValue): ProductInformationInterface
    {
        $this->attributeValues->remove($attributeValue->getCode());

        return $this;
    }

    public function removeAttributeValueByCode(string $code): ProductInformationInterface
    {
        $this->attributeValues->remove($code);

        return $this;
    }

    public function findAttributeValueByCode(string $code): ?ProductInformationAttributeValueInterface
    {
        if (!$this->attributeValues->containsKey($code)) {
            return null;
        }

        return $this->attributeValues->get($code);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeValueCodes(): array
    {
        return $this->attributeValues->getKeys();
    }
}
