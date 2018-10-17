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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\DimensionTrait;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductInformationTrait;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class SynchronizeProductTest extends SuluTestCase
{
    use DimensionTrait;
    use ProductInformationTrait;

    public function setUp()
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

        /** @var ProductInterface $product */
        $product = $messageBus->dispatch($message);

        $result = $this->findProductInformation($product->getId(), 'de');
        $this->assertNotNull($result);
        if (!$result) {
            return;
        }

        $this->assertEquals($product->getId(), $result->getProductId());
        $this->assertEquals('Produkt Eins', $result->getName());
        $this->assertCount(1, $result->getVariants());
        $this->assertEquals('variant-1', $result->getVariants()[0]->getCode());
        $this->assertEquals('Produkt Variante Eins', $result->getVariants()[0]->getName());

        $result = $this->findProductInformation($product->getId(), 'en');
        $this->assertNotNull($result);
        if (!$result) {
            return;
        }

        $this->assertEquals($product->getId(), $result->getProductId());
        $this->assertEquals('Product One', $result->getName());
        $this->assertCount(1, $result->getVariants());
        $this->assertEquals('variant-1', $result->getVariants()[0]->getCode());
        $this->assertEquals('Product Variant One', $result->getVariants()[0]->getName());
    }
}
