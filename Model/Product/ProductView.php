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

use Sulu\Bundle\CategoryBundle\Api\Category;
use Sulu\Bundle\MediaBundle\Api\Media;
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
     * @var ProductInterface
     */
    private $product;

    /**
     * @var ProductInformationInterface
     */
    private $productInformation;

    /**
     * @var null|Category
     */
    private $mainCategory;

    /**
     * @var Category[]
     */
    private $categories;

    /**
     * @var Media[]
     */
    private $media;

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
        ProductInterface $product,
        ProductInformationInterface $productInformation,
        ?Category $mainCategory,
        array $categories,
        array $media,
        ContentViewInterface $content,
        RoutableResourceInterface $routableResource
    ) {
        $this->id = $id;
        $this->locale = $locale;
        $this->product = $product;
        $this->productInformation = $productInformation;
        $this->mainCategory = $mainCategory;
        $this->categories = $categories;
        $this->media = $media;
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

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getProductInformation(): ProductInformationInterface
    {
        return $this->productInformation;
    }

    public function getMainCategory(): ?Category
    {
        return $this->mainCategory;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getMedia(): array
    {
        return $this->media;
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
