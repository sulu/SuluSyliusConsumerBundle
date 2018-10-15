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

use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;

class ProductView extends Product implements ProductViewInterface
{
    /**
     * @var ProductInformationInterface
     */
    private $productInformation;

    /**
     * @var ContentInterface
     */
    private $content;

    /**
     * @var RoutableResourceInterface
     */
    private $routableResource;

    public function setProductInformation(ProductInformationInterface $productInformation): ProductViewInterface
    {
        $this->productInformation = $productInformation;

        return $this;
    }

    public function setContent(ContentInterface $content): ProductViewInterface
    {
        $this->content = $content;

        return $this;
    }

    public function setRoutableResource(RoutableResourceInterface $routableResource): ProductViewInterface
    {
        $this->routableResource = $routableResource;

        return $this;
    }

    public function getName(): string
    {
        return $this->productInformation->getName();
    }

    public function getVariants(): array
    {
        return $this->productInformation->getVariants();
    }

    public function getContentType(): ?string
    {
        return $this->content->getType();
    }

    public function getContentData(): array
    {
        return $this->content->getData();
    }

    public function getRoutePath(): string
    {
        return $this->routableResource->getRoute()->getPath();
    }
}
