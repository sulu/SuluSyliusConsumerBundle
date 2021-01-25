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

namespace Sulu\Bundle\SyliusConsumerBundle\Handler;

use Sulu\Bundle\SyliusConsumerBundle\Adapter\ProductVariantAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Message\RemoveProductVariantMessage;

class RemoveProductVariantMessageHandler
{
    /**
     * @var iterable<ProductVariantAdapterInterface>
     */
    private $productVariantAdapters;

    public function __construct(iterable $productVariantAdapters)
    {
        $this->productVariantAdapters = $productVariantAdapters;
    }

    public function __invoke(RemoveProductVariantMessage $message): void
    {
        foreach ($this->productVariantAdapters as $productVariantAdapter) {
            $productVariantAdapter->remove($message->getCode());
        }
    }
}
