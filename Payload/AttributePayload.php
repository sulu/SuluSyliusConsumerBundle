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

class AttributePayload
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Payload
     */
    private $payload;

    public function __construct(int $id, array $payload)
    {
        $this->id = $id;
        $this->payload = new Payload($payload);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->payload->getStringValue('code');
    }

    public function getType(): string
    {
        return $this->payload->getStringValue('type');
    }

    public function isTranslatable(): bool
    {
        return $this->payload->getNullableBoolValue('translatable', true) ?? false;
    }

    /**
     * @return AttributeTranslationPayload[]
     */
    public function getTranslations(): array
    {
        $translations = [];
        foreach ($this->payload->getArrayValue('translations') as $translationPayload) {
            $translations[$translationPayload['locale']] = new AttributeTranslationPayload($translationPayload);
        }

        return $translations;
    }

    public function getConfiguration(): Payload
    {
        return new Payload($this->payload->getNullableArrayValue('configuration', true) ?? []);
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
