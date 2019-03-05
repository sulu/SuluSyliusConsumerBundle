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

class FindProductViewQuery
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var ProductViewInterface|null
     */
    private $productView;

    public function __construct(string $id, string $locale)
    {
        $this->id = $id;
        $this->locale = $locale;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getProductView(): ProductViewInterface
    {
        if (!$this->productView) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->productView;
    }

    public function setProductView(ProductViewInterface $productView): self
    {
        $this->productView = $productView;

        return $this;
    }
}
