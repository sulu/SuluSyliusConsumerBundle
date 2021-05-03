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

use Sulu\Bundle\SyliusConsumerBundle\Adapter\TaxonAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Message\RemoveTaxonMessage;

class RemoveTaxonMessageHandler
{
    /**
     * @var iterable<TaxonAdapterInterface>
     */
    private $taxonAdapters;

    public function __construct(iterable $taxonAdapters)
    {
        $this->taxonAdapters = $taxonAdapters;
    }

    public function __invoke(RemoveTaxonMessage $message): void
    {
        foreach ($this->taxonAdapters as $taxonAdapter) {
            $taxonAdapter->remove($message->getId());
        }
    }
}
