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

class ProductDTO
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
     * @return ProductTranslationDTO[]
     */
    public function getTranslations(): array
    {
        return array_map(
            function (array $payload) {
                return new ProductTranslationDTO($payload);
            },
            $this->getArrayValue('translations')
        );
    }

    /**
     * @return ProductVariantDTO[]
     */
    public function getVariants(): array
    {
        return array_map(
            function (array $payload) {
                return new ProductVariantDTO($payload);
            },
            $this->getArrayValue('variants')
        );
    }
}
