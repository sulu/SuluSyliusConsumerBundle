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

use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;
use Sulu\Bundle\SyliusConsumerBundle\Model\PayloadTrait;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\OptionValueValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\ProductVariantTranslationValueObject;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductVariantInterface;

class SynchronizeProductVariantMessage
{
    use PayloadTrait;

    /**
     * @var string
     */
    private $productCode;

    /**
     * @var string
     */
    private $code;

    /**
     * @var ProductVariantInterface|null
     */
    private $productVariant;

    public function __construct(string $productCode, string $code, array $payload)
    {
        $this->productCode = $productCode;
        $this->code = $code;
        $this->initializePayload($payload);
    }

    public function getProductCode(): string
    {
        return $this->productCode;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return ProductVariantTranslationValueObject[]
     */
    public function getTranslations(): array
    {
        $translations = [];
        foreach ($this->getArrayValue('translations') as $locale => $translationData) {
            $translations[] = new ProductVariantTranslationValueObject($translationData);
        }

        return $translations;
    }

    /**
     * @return OptionValueValueObject[]
     */
    public function getOptionValues(): array
    {
        return array_map(
            function (array $payload) {
                return new OptionValueValueObject($payload);
            },
            $this->getArrayValue('optionValues')
        );
    }

    public function getCustomData(): array
    {
        return $this->getArrayValueWithDefault('customData');
    }

    public function getProductVariant(): ProductVariantInterface
    {
        if (!$this->productVariant) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->productVariant;
    }

    public function setProductVariant(ProductVariantInterface $productVariant): self
    {
        $this->productVariant = $productVariant;

        return $this;
    }
}
