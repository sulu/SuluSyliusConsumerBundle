<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Payload;

use Sulu\Bundle\SyliusConsumerBundle\Common\Payload;

class AttributeValuePayload
{
    /**
     * @var Payload
     */
    private $payload;

    public function __construct(array $payload)
    {
        $this->payload = new Payload($payload);
    }

    public function getCode(): string
    {
        return $this->payload->getStringValue('code');
    }

    public function getLocaleCode(): ?string
    {
        return $this->payload->getNullableStringValue('localeCode', true);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->payload->getValue('value');
    }

    public function getAttribute(): AttributePayload
    {
        $attributePayload = $this->payload->getArrayValue('attribute');

        return new AttributePayload($attributePayload['id'], $attributePayload);
    }

    public function getCustomData(): Payload
    {
        return new Payload($this->payload->getNullableArrayValue('customData', true) ?? []);
    }

    public function getPayload(): Payload
    {
        return $this->payload;
    }
}
