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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\ValueObject\TaxonTranslationValueObject;

class SynchronizeTaxonMessage
{
    use PayloadTrait;

    /**
     * @var int
     */
    private $id;

    public function __construct(int $id, array $payload)
    {
        $this->id = $id;
        $this->initializePayload($payload);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->getStringValue('code');
    }

    public function getLeft(): int
    {
        return $this->getIntValue('left');
    }

    public function getRight(): int
    {
        return $this->getIntValue('right');
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
        foreach ($this->getArrayValue('children') as $child) {
            $children[] = new SynchronizeTaxonMessage($child['id'], $child);
        }

        return $children;
    }

    public function getParent(): ?SynchronizeTaxonMessage
    {
        $parent = $this->getArrayValueWithDefault('parent');
        if (!$parent) {
            return null;
        }

        return new SynchronizeTaxonMessage($parent['id'], $parent);
    }

    /**
     * @return TaxonTranslationValueObject[]
     */
    public function getTranslations(): array
    {
        $translations = [];
        foreach ($this->getArrayValue('translations') as $locale => $translationData) {
            $translations[] = new TaxonTranslationValueObject($translationData);
        }

        return $translations;
    }
}
