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
use Sulu\Component\Localization\Localization;

class TaxonTranslationPayload
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

    public function getLocale(): string
    {
        return $this->getStringValue('locale');
    }

    public function getLocalization(): Localization
    {
        return Localization::createFromString($this->getLocale(), Localization::LCID);
    }

    public function getName(): string
    {
        return $this->getStringValue('name');
    }

    public function getSlug(): string
    {
        return $this->getStringValue('slug');
    }

    public function getDescription(): string
    {
        return $this->getStringValue('description');
    }
}
