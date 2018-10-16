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

class ListProductsQuery
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $route;

    /**
     * @var array
     */
    private $query;

    public function __construct(string $locale, string $route, array $query)
    {
        $this->locale = $locale;
        $this->route = $route;
        $this->query = $query;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getQuery(): array
    {
        return $this->query;
    }
}
