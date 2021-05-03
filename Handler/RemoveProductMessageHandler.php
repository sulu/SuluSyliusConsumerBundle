<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Handler;

use Sulu\Bundle\SyliusConsumerBundle\Adapter\ProductAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Message\RemoveProductMessage;

class RemoveProductMessageHandler
{
    /**
     * @var iterable<ProductAdapterInterface>
     */
    private $productAdapters;

    public function __construct(iterable $productAdapters)
    {
        $this->productAdapters = $productAdapters;
    }

    public function __invoke(RemoveProductMessage $message): void
    {
        foreach ($this->productAdapters as $productAdapter) {
            $productAdapter->remove($message->getCode());
        }
    }
}
