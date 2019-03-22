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

use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductViewInterface;

class FindProductViewsQuery
{
    /**
     * @var string[]
     */
    private $ids;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var ProductViewInterface[]|null
     */
    private $productViews;

    public function __construct(array $ids, string $locale)
    {
        $this->ids = $ids;
        $this->locale = $locale;
    }

    public function getIds(): array
    {
        return $this->ids;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getProductViews(): array
    {
        if (null === $this->productViews) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->productViews;
    }

    public function setProductViews(array $productViews): self
    {
        $this->productViews = $productViews;

        return $this;
    }
}
