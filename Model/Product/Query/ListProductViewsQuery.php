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
     * @var null|int
     */
    private $page;

    /**
     * @var null|int
     */
    private $pageSize;

    /**
     * @var null|string
     */
    private $query;

    /**
     * @var string[]
     */
    private $categoryKeys;

    /**
     * @var array
     */
    private $attributesFilter;

    public function __construct(
        string $locale,
        ?int $page = null,
        ?int $pageSize = null,
        ?string $query = null,
        array $categoryKeys = [],
        array $attributesFilter = []
    ) {
        $this->locale = $locale;
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->query = $query;
        $this->categoryKeys = $categoryKeys;
        $this->attributesFilter = $attributesFilter;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getPageSize(): ?int
    {
        return $this->pageSize;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function getCategoryKeys(): array
    {
        return $this->categoryKeys;
    }

    public function getAttributesFilter(): array
    {
        return $this->attributesFilter;
    }
}
