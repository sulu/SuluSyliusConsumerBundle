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

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\RemoveProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\DimensionTrait;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductInformationTrait;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductTrait;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class RemoveProductTest extends SuluTestCase
{
    use DimensionTrait;
    use ProductTrait;
    use ProductInformationTrait;

    protected function setUp(): void
    {
        $this->purgeDatabase();
    }

    public function testRemoveProduct()
    {
        $product = $this->createProduct('product-1');
        $productInformationEN = $this->createProductInformation($product->getId(), 'en');
        $productInformationDE = $this->createProductInformation($product->getId(), 'de');

        $message = new RemoveProductMessage($product->getCode());

        /** @var MessageBusInterface $messageBus */
        $messageBus = $this->getContainer()->get('sulu_sylius_consumer_test.messenger.bus.default');
        $messageBus->dispatch($message);

        $this->assertNull($this->findProduct($product->getCode()));
        $this->assertNull($this->findProductInformation($productInformationEN->getProductId(), 'en'));
        $this->assertNull($this->findProductInformation($productInformationDE->getProductId(), 'de'));
    }
}
