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

namespace Sulu\Bundle\SyliusConsumerBundle\Payload;

use Sulu\Bundle\SyliusConsumerBundle\Common\Payload;

class ProductVariantPayload
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $productCode;

    /**
     * @var Payload
     */
    private $payload;

    public function __construct(string $code, string $productCode, array $payload)
    {
        $this->code = $code;
        $this->productCode = $productCode;
        $this->payload = new Payload($payload);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getProductCode(): string
    {
        return $this->productCode;
    }

    /**
     * @return ProductVariantTranslationPayload[]
     */
    public function getTranslations(): array
    {
        $translations = [];
        foreach ($this->payload->getArrayValue('translations') as $translationPayload) {
            $translation = new ProductVariantTranslationPayload($translationPayload);
            $translations[$translation->getLocale()] = $translation;
        }

        return $translations;
    }

    public function getPayload(): Payload
    {
        return $this->payload;
    }
}
