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

class SynchronizeProductMessage
{
    use PayloadTrait;

    /**
     * @var string
     */
    private $code;

    public function __construct(string $code, array $payload)
    {
        $this->code = $code;
        $this->initializePayload($payload);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return ProductTranslationValueObject[]
     */
    public function getTranslations(): array
    {
        $translations = [];
        foreach ($this->getArrayValue('translations') as $locale => $translationData) {
            $translations[] = new ProductTranslationValueObject($translationData);
        }

        return $translations;
    }

    /**
     * @return ProductImageValueObject[]
     */
    public function getImages(): array
    {
        $images = [];
        foreach ($this->getArrayValue('images') as $imagePayload) {
            $images[] = new ProductImageValueObject($imagePayload);
        }

        return $images;
    }
}
