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

class ProductTranslationValueObject
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
        $value = $this->getNullableStringValue('name');
        if (null === $value) {
            return '';
        }

        return $value;
    }

    public function getSlug(): string
    {
        $value = $this->getNullableStringValue('slug');
        if (null === $value) {
            return '';
        }

        return $value;
    }

    public function getDescription(): string
    {
        $value = $this->getNullableStringValue('description');
        if (null === $value) {
            return '';
        }

        return $value;
    }

    public function getMetaKeywords(): string
    {
        $value = $this->getNullableStringValue('metaKeywords');
        if (null === $value) {
            return '';
        }

        return $value;
    }

    public function getMetaDescription(): string
    {
        $value = $this->getNullableStringValue('metaDescription');
        if (null === $value) {
            return '';
        }

        return $value;
    }

    public function getShortDescription(): string
    {
        $value = $this->getNullableStringValue('shortDescription');
        if (null === $value) {
            return '';
        }

        return $value;
    }

    public function getCustomData(): array
    {
        return $this->getArrayValueWithDefault('customData');
    }
}
