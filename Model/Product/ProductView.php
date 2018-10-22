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
    private $locale;

    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @var ProductInformationInterface
     */
    private $productInformation;

    /**
     * @var ContentViewInterface
     */
    private $content;

    /**
     * @var RoutableResourceInterface
     */
    private $routableResource;

    public function __construct(
        string $locale,
        ProductInterface $product,
        ProductInformationInterface $productInformation,
        ContentViewInterface $content,
        RoutableResourceInterface $routableResource
    ) {
        $this->locale = $locale;
        $this->product = $product;
        $this->productInformation = $productInformation;
        $this->content = $content;
        $this->routableResource = $routableResource;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getProductInformation(): ProductInformationInterface
    {
        return $this->productInformation;
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
