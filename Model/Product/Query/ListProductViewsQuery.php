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
    private $limit;

    /**
     * @var null|string
     */
    private $query;

    /**
     * @var string[]
     */
    private $categoryKeys;

    /**
     * @var string[]
     */
    private $queryFields;

    /**
     * @var array
     */
    private $attributeFilters;

    /**
     * @var bool
     */
    private $loadAttributeTranslations;

    public function __construct(
        string $locale,
        ?int $page = null,
        ?int $limit = null,
        ?string $query = null,
        array $queryFields = [],
        array $categoryKeys = [],
        array $attributeFilters = [],
        bool $loadAttributeTranslations = false
    ) {
        $this->locale = $locale;
        $this->page = $page;
        $this->limit = $limit;
        $this->query = $query;
        $this->queryFields = $queryFields;
        $this->categoryKeys = $categoryKeys;
        $this->attributeFilters = $attributeFilters;
        $this->loadAttributeTranslations = $loadAttributeTranslations;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function getQueryFields(): array
    {
        return $this->queryFields;
    }

    public function getCategoryKeys(): array
    {
        return $this->categoryKeys;
    }

    public function getAttributeFilters(): array
    {
        return $this->attributeFilters;
    }

    public function loadAttributeTranslations(): bool
    {
        return $this->loadAttributeTranslations;
    }
}
