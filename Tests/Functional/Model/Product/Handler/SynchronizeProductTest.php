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
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\DimensionTrait;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductDataTrait;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class SynchronizeProductTest extends SuluTestCase
{
    use DimensionTrait;
    use ProductDataTrait;

    public function setUp()
    {
        $this->purgeDatabase();
    }

    public function testSynchronizeProductCreate()
    {
        $message = new SynchronizeProductMessage(
            'product-1',
            [
               'translations' => [
                   'en' => [
                       'locale' => 'en',
                       'name' => 'Product One',
                   ],
                   'de' => [
                       'locale' => 'de',
                       'name' => 'Produkt Eins',
                   ],
               ],
               'variants' => [
                   [
                       'code' => 'variant-1',
                       'translations' => [
                           [
                               'locale' => 'en',
                               'name' => 'Product Variant One',
                           ],
                           [
                               'locale' => 'de',
                               'name' => 'Produkt Variante Eins',
                           ],
                       ],
                   ],
               ],
           ]
        );

        /** @var MessageBusInterface $messageBus */
        $messageBus = $this->getContainer()->get('sulu_sylius_consumer_test.messenger.bus.default');
        $messageBus->dispatch($message);

        $result = $this->findProductData('product-1', 'de');
        $this->assertNotNull($result);
        if (!$result) {
            return;
        }

        $this->assertEquals('product-1', $result->getCode());
        $this->assertEquals('Produkt Eins', $result->getName());
        $this->assertCount(1, $result->getVariants());
        $this->assertEquals('variant-1', $result->getVariants()[0]->getCode());
        $this->assertEquals('Produkt Variante Eins', $result->getVariants()[0]->getName());

        $result = $this->findProductData('product-1', 'en');
        $this->assertNotNull($result);
        if (!$result) {
            return;
        }

        $this->assertEquals('product-1', $result->getCode());
        $this->assertEquals('Product One', $result->getName());
        $this->assertCount(1, $result->getVariants());
        $this->assertEquals('variant-1', $result->getVariants()[0]->getCode());
        $this->assertEquals('Product Variant One', $result->getVariants()[0]->getName());
    }
}
