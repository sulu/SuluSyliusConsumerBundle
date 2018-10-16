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

class ProductVariantValueObject
{
    use PayloadTrait;

    public function __construct(array $payload)
    {
        $this->initializePayload($payload);
    }

    public function getCode(): string
    {
        return $this->getStringValue('code');
    }

    /**
     * @return ProductVariantTranslationValueObject[]
     */
    public function getTranslations(): array
    {
        return array_map(
            function (array $payload) {
                return new ProductVariantTranslationValueObject($payload);
            },
            $this->getArrayValue('translations')
        );
    }

    public function findTranslationByLocale(string $locale): ?ProductVariantTranslationValueObject
    {
        foreach ($this->getTranslations() as $translation) {
            if ($locale === $translation->getLocale()) {
                return $translation;
            }
        }

        return null;
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
}
