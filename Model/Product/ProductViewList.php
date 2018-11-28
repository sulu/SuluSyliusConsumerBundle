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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product;

class ProductViewList implements ProductViewListInterface
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $pages;

    /**
     * @var int
     */
    private $total;

    /**
     * @var ProductViewInterface[]
     */
    private $productViews;

    public function __construct(
        int $page,
        int $limit,
        int $total,
        array $productViews
    ) {
        $this->page = $page;
        $this->limit = $limit;
        $this->pages = intval(ceil($total / $limit));
        $this->total = $total;
        $this->productViews = $productViews;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getProductViews(): array
    {
        return $this->productViews;
    }
}
