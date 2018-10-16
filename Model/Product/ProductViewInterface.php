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

interface ProductViewInterface extends ProductInterface
{
    public function setProductInformation(ProductInformationInterface $productInformation): ProductViewInterface;

    public function setContent(ContentInterface $content): ProductViewInterface;

    public function setRoutableResource(RoutableResourceInterface $routableResource): ProductViewInterface;

    public function getName(): string;

    /**
     * @return ProductInformationVariantInterface[]
     */
    public function getVariants(): array;

    public function getContentType(): ?string;

    public function getContentData(): array;

    public function getRoutePath(): string;
}
