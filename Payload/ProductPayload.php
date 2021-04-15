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
use Sulu\Exception\FeatureNotImplementedException;

class ProductPayload
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var Payload
     */
    private $payload;

    public function __construct(string $code, array $payload)
    {
        $this->code = $code;
        $this->payload = new Payload($payload);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function isEnabled(): bool
    {
        return $this->payload->getBoolValue('enabled');
    }

    public function getMainTaxonId(): ?int
    {
        return $this->payload->getNullableIntValue('mainTaxonId');
    }

    /**
     * @return int[]
     */
    public function getTaxonIds(): array
    {
        return array_map(function (array $taxon) {
            return $taxon['taxonId'];
        }, $this->payload->getArrayValue('productTaxons'));
    }

    /**
     * @return ProductTranslationPayload[]
     */
    public function getTranslations(): array
    {
        $translations = [];
        foreach ($this->payload->getArrayValue('translations') as $translationPayload) {
            $translation = new ProductTranslationPayload($translationPayload);
            $translations[$translation->getLocale()] = $translation;
        }

        return $translations;
    }

    /**
     * @return ProductVariantPayload[]
     */
    public function getVariants(): array
    {
        $variants = [];
        foreach ($this->payload->getArrayValue('variants') as $variantPayload) {
            $variants[] = new ProductVariantPayload($variantPayload['code'], $variantPayload);
        }

        return $variants;
    }

    /**
     * @return mixed[]
     */
    public function getImages(): array
    {
        throw new FeatureNotImplementedException('Images are not implemented');
    }

    public function getPayload(): Payload
    {
        return $this->payload;
    }
}
