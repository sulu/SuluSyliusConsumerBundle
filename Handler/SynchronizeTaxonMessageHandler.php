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

use Sulu\Bundle\SyliusConsumerBundle\Adapter\TaxonAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeTaxonMessage;
use Sulu\Bundle\SyliusConsumerBundle\Payload\TaxonPayload;

class SynchronizeTaxonMessageHandler
{
    /**
     * @var iterable<TaxonAdapterInterface>
     */
    private $taxonAdapters;

    public function __construct(iterable $taxonAdapters)
    {
        $this->taxonAdapters = $taxonAdapters;
    }

    public function __invoke(SynchronizeTaxonMessage $message): void
    {
        foreach ($this->taxonAdapters as $taxonAdapter) {
            $taxonAdapter->synchronize(new TaxonPayload($message->getId(), $message->getPayload()));
        }
    }
}
