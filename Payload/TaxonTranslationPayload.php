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

class TaxonTranslationPayload
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
        return $this->payload->getStringValue('name');
    }

    public function getSlug(): string
    {
        return $this->payload->getStringValue('slug');
    }

    public function getDescription(): string
    {
        if (!$this->payload->keyExists('description')) {
            return '';
        }

        return $this->payload->getNullableStringValue('description') ?? '';
    }

    public function getPayload(): Payload
    {
        return $this->payload;
    }
}
