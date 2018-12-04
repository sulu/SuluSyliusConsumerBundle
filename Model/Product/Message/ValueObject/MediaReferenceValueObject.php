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

class MediaReferenceValueObject
{
    use PayloadTrait;

    public function __construct(array $payload)
    {
        $this->initializePayload($payload);
    }

    public function getMediaId(): int
    {
        return $this->getIntValue('mediaId');
    }

    public function getType(): string
    {
        return $this->getStringValue('type');
    }

    public function getSorting(): int
    {
        return $this->getIntValue('sorting');
    }

    public function getActive(): bool
    {
        return $this->getBoolValue('active');
    }
}
