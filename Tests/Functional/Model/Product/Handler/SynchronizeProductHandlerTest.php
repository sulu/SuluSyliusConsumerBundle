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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Model\Product\Handler;

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductTrait;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class SynchronizeProductHandlerTest extends SuluTestCase
{
    use ProductTrait;

    public function testSynchronizeProductCreate()
    {
        $message = new SynchronizeProductMessage(
            'product-1',
            [
               'product' => [
                   'code' => 'product-1',
                   'variants' => [
                       ['code' => 'variant-1'],
                   ],
               ],
           ]
        );

        /** @var MessageBusInterface $messageBus */
        $messageBus = $this->getContainer()->get('sulu_sylius_consumer_test.messenger.bus.default');
        $messageBus->dispatch($message);

        $result = $this->findProduct('product-1');
        $this->assertNotNull($result);
        if (!$result) {
            return;
        }

        $this->assertEquals('product-1', $result->getCode());
        $this->assertCount(1, $result->getVariants());
        $this->assertEquals('variant-1', $result->getVariants()[0]->getCode());
    }
}
