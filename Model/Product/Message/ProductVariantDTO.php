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

class ProductVariantDTO
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
     * @return ProductVariantTranslationDTO[]
     */
    public function getTranslations(): array
    {
        return array_map(
            function (array $payload) {
                return new ProductVariantTranslationDTO($payload);
            },
            $this->getArrayValue('translations')
        );
    }

    /**
     * @return OptionValueDTO[]
     */
    public function getOptionValues(): array
    {
        return array_map(
            function (array $payload) {
                return new OptionValueDTO($payload);
            },
            $this->getArrayValue('optionValues')
        );
    }
}
