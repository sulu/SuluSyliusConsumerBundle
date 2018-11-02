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

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentViewInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;

class ProductView implements ProductViewInterface
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
     * @var array
     */
    private $productData;

    /**
     * @var ContentViewInterface
     */
    private $content;

    /**
     * @var RoutableResourceInterface
     */
    private $routableResource;

    public function __construct(
        string $id,
        string $locale,
        array $productData,
        ContentViewInterface $content,
        RoutableResourceInterface $routableResource
    ) {
        $this->id = $id;
        $this->locale = $locale;
        $this->productData = $productData;
        $this->content = $content;
        $this->routableResource = $routableResource;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getProductData(): array
    {
        return $this->productData;
    }

    public function getContent(): ContentViewInterface
    {
        return $this->content;
    }

    public function getRoutableResource(): RoutableResourceInterface
    {
        return $this->routableResource;
    }
}
