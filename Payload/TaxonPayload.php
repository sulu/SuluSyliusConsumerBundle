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

use Sulu\Bundle\SyliusConsumerBundle\Common\PayloadTrait;

class TaxonPayload
{
    use PayloadTrait;

    /**
     * @var int
     */
    private $id;

    public function __construct(int $id, array $payload)
    {
        $this->initializePayloadTrait($payload);

        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->getStringValue('code');
    }

    public function getLevel(): int
    {
        return $this->getIntValue('level');
    }

    public function getPosition(): int
    {
        return $this->getIntValue('position');
    }

    public function getChildren(): array
    {
        $children = [];
        foreach ($this->getArrayValue('children') as $childrenPayload) {
            $id = $childrenPayload['id'];
            $children[] = new TaxonPayload($id, $childrenPayload);
        }

        return $children;
    }

    /**
     * @return TaxonTranslationPayload[]
     */
    public function getTranslations(): array
    {
        $translations = [];
        foreach ($this->getArrayValue('translations') as $locale => $translationPayload) {
            $id = $translationPayload['id'];
            $translations[$locale] = new TaxonTranslationPayload($id, $translationPayload);
        }

        return $translations;
    }
}
