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

trait ProductPayloadTrait
{
    use PayloadTrait;

    /**
     * @return ProductTranslationValueObject[]
     */
    public function getTranslations(): array
    {
        return array_map(
            function (array $payload) {
                return new ProductTranslationValueObject($payload);
            },
            $this->getArrayValue('translations')
        );
    }

    /**
     * @return ProductVariantValueObject[]
     */
    public function getVariants(): array
    {
        return array_map(
            function (array $payload) {
                return new ProductVariantValueObject($payload);
            },
            $this->getArrayValue('variants')
        );
    }
}
