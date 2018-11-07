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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject;

use Sulu\Bundle\SyliusConsumerBundle\Model\PayloadTrait;

class ProductAttributeValueValueObject
{
    use PayloadTrait;

    public function __construct(array $payload)
    {
        $this->initializePayload($payload);
    }

    public function getId(): int
    {
        return $this->getIntValue('id');
    }

    public function getCode(): string
    {
        return $this->getStringValue('code');
    }

    public function getType(): string
    {
        return $this->getStringValue('type');
    }

    public function getAttributeValue()
    {
        return $this->getValue('value');
    }

    public function getLocaleCode(): string
    {
        return $this->getStringValue('localeCode');
    }
}
