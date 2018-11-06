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

class ProductVariantTranslationValueObject
{
    use PayloadTrait;

    public function __construct(array $payload)
    {
        $this->initializePayload($payload);
    }

    public function getLocale(): string
    {
        return strtolower($this->getStringValue('locale'));
    }

    public function getName(): string
    {
        return $this->getStringValueWithDefault('name', '');
    }

    public function getCustomData(): array
    {
        return $this->getArrayValueWithDefault('customData');
    }
}
