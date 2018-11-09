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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query;

class ListProductViewsQuery
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var null|string
     */
    private $query;

    /**
     * @var string[]
     */
    private $categoryKeys;

    public function __construct(string $locale, ?string $query, array $categoryKeys)
    {
        $this->locale = $locale;
        $this->query = $query;
        $this->categoryKeys = $categoryKeys;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function getCategoryKeys(): array
    {
        return $this->categoryKeys;
    }
}
