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
use Sulu\Component\Localization\Localization;

class ProductTranslationPayload
{
    /**
     * @var Payload
     */
    private $payload;

    public function __construct(array $payload)
    {
        $this->payload = new Payload($payload);
    }

    public function getLocale(): string
    {
        return $this->getLocalization()->getLocale();
    }

    public function getLocalization(): Localization
    {
        return Localization::createFromString($this->payload->getStringValue('locale'), Localization::LCID);
    }

    public function getName(): string
    {
        return $this->payload->getNullableStringValue('name', true) ?? '';
    }

    public function getSlug(): string
    {
        return $this->payload->getNullableStringValue('slug', true) ?? '';
    }

    public function getDescription(): ?string
    {
        return $this->payload->getNullableStringValue('description', true);
    }

    public function getShortDescription(): ?string
    {
        return $this->payload->getNullableStringValue('shortDescription', true);
    }

    public function getMetaKeywords(): ?string
    {
        return $this->payload->getNullableStringValue('metaKeywords', true);
    }

    public function getMetaDescription(): ?string
    {
        return $this->payload->getNullableStringValue('metaDescription', true);
    }

    public function getPayload(): Payload
    {
        return $this->payload;
    }
}
