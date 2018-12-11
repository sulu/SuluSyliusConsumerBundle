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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Attribute\Query;

class FindAttributeTranslationsByCodesQuery
{
    /**
     * @var string[]
     */
    private $codes;

    public function __construct(string $locale, array $codes)
    {
        $this->locale = $locale;
        $this->codes = $codes;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getCodes(): array
    {
        return $this->codes;
    }
}
