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

use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;

class FindAttributeTranslationsByCodesQuery
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var string[]
     */
    private $codes;

    /**
     * @var array|null
     */
    protected $productAttributeTranslations;

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

    public function getProductAttributeTranslations(): array
    {
        if (!$this->productAttributeTranslations) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->productAttributeTranslations;
    }

    public function setProductAttributeTranslations(array $productAttributeTranslations): self
    {
        $this->productAttributeTranslations = $productAttributeTranslations;

        return $this;
    }
}
