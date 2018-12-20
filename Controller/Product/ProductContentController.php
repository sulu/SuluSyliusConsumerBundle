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

namespace Sulu\Bundle\SyliusConsumerBundle\Controller\Product;

use FOS\RestBundle\Controller\Annotations as Rest;
use Sulu\Bundle\SyliusConsumerBundle\Controller\Content\ContentController;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\PublishProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;

/**
 * @Rest\RouteResource("product-content")
 */
class ProductContentController extends ContentController
{
    protected function getResourceKey(): string
    {
        return ProductInterface::CONTENT_RESOURCE_KEY;
    }

    protected function handlePublish(string $resourceId, string $locale): void
    {
        $this->messageBus->dispatch(new PublishProductMessage($resourceId, $locale));
    }
}
