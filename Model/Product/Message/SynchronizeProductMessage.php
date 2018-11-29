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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message;

use Sulu\Bundle\SyliusConsumerBundle\Model\PayloadTrait;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\ProductAttributeValueValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\ProductImageValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\ProductTaxonValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\ProductTranslationValueObject;

class SynchronizeProductMessage
{
    use PayloadTrait;

    /**
     * @var string
     */
    private $code;

    public function __construct(string $code, array $payload)
    {
        $this->code = $code;
        $this->initializePayload($payload);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getEnabled(): bool
    {
        return $this->getBoolValue('enabled');
    }

    /**
     * @return ProductTranslationValueObject[]
     */
    public function getTranslations(): array
    {
        $translations = [];
        foreach ($this->getArrayValue('translations') as $locale => $translationData) {
            $translations[] = new ProductTranslationValueObject($translationData);
        }

        return $translations;
    }

    /**
     * @return ProductImageValueObject[]
     */
    public function getImages(): array
    {
        $images = [];
        foreach ($this->getArrayValue('images') as $imagePayload) {
            $images[] = new ProductImageValueObject($imagePayload);
        }

        return $images;
    }

    public function getMainTaxonId(): ?int
    {
        return $this->getNullableIntValue('mainTaxonId');
    }

    /**
     * @return ProductTaxonValueObject[]
     */
    public function getProductTaxons(): array
    {
        $taxons = [];
        foreach ($this->getArrayValueWithDefault('productTaxons') as $productTaxonPayload) {
            $taxons[] = new ProductTaxonValueObject($productTaxonPayload);
        }

        return $taxons;
    }

    /**
     * @return ProductAttributeValueValueObject[]
     */
    public function getAttributeValues(string $locale): array
    {
        $attributeValues = [];
        foreach ($this->getArrayValueWithDefault('attributes') as $attributePayload) {
            $attributeValue = new ProductAttributeValueValueObject($attributePayload);

            if ($locale !== $attributeValue->getLocaleCode()) {
                continue;
            }

            $attributeValues[] = $attributeValue;
        }

        return $attributeValues;
    }

    public function getVariants(): array
    {
        return $this->getArrayValueWithDefault('variants');
    }

    public function getCustomData(): array
    {
        return $this->getArrayValueWithDefault('customData');
    }
}
