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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformation;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\DimensionTrait;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductInformationTrait;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class SynchronizeProductTest extends SuluTestCase
{
    use DimensionTrait;
    use ProductInformationTrait;

    protected function setUp(): void
    {
        $this->purgeDatabase();
    }

    public function testSynchronizeProductCreate()
    {
        $message = new SynchronizeProductMessage(
            ExampleSynchronizeProductMessage::getCode(),
            ExampleSynchronizeProductMessage::getPayload()
        );

        /** @var MessageBusInterface $messageBus */
        $messageBus = $this->getContainer()->get('sulu_sylius_consumer_test.messenger.bus.default');

        $messageBus->dispatch($message);

        /** @var ProductInformation|null $result */
        $result = $this->findProductInformationByCode(ExampleSynchronizeProductMessage::getCode(), 'de');
        $this->assertNotNull($result);

        if (!$result) {
            return;
        }

        $this->assertTrue(is_string($result->getProductId()));
        $this->assertEquals(ExampleSynchronizeProductMessage::getCode(), $result->getProductCode());
        $this->assertEquals('SB verpackt zu je 1', $result->getName());
    }
}
