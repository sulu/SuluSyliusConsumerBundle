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

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\PublishProductMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\ListProductViewsQuery;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\DimensionTrait;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductInformationTrait;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductTrait;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class ListProductViewsQueryTest extends SuluTestCase
{
    use DimensionTrait;
    use ProductInformationTrait;
    use ProductTrait;

    public function setUp()
    {
        $this->purgeDatabase();
    }

    public function testMin(): void
    {
        $product1 = $this->create('product-1', 'Product One', 'en');
        $product2 = $this->create('product-2', 'Product Two', 'en');
        $product3 = $this->create('product-3', 'Product Three', 'en', false);
        $product4 = $this->create('product-4', 'Product Four', 'en');
        $product5 = $this->create('product-5', 'Product Five', 'en');

        $query = new ListProductViewsQuery('en');
        $result = $this->getMessageBus()->dispatch($query);

        $this->assertCount(4, $result);
    }

    public function testPagination(): void
    {
        $product1 = $this->create('product-1', 'Product One', 'en');
        $product2 = $this->create('product-2', 'Product Two', 'en');
        $product3 = $this->create('product-3', 'Product Three', 'en', false);
        $product4 = $this->create('product-4', 'Product Four', 'en');
        $product5 = $this->create('product-5', 'Product Five', 'en');

        $query = new ListProductViewsQuery('en', 2, 2);
        $result = $this->getMessageBus()->dispatch($query);

        $this->assertCount(2, $result);
    }

    public function testSearch(): void
    {
        $product1 = $this->create('product-1', 'Product One', 'en');
        $product2 = $this->create('product-2', 'Product Two', 'en');
        $product3 = $this->create('product-3', 'Product Three', 'en', false);
        $product4 = $this->create('product-4', 'Product Four', 'en');
        $product5 = $this->create('product-5', 'Product Five', 'en');

        $query = new ListProductViewsQuery('en', null, null, 'four');
        $result = $this->getMessageBus()->dispatch($query);

        $this->assertCount(1, $result);
    }

    private function create(
        string $productCode,
        string $productName,
        string $locale,
        bool $createLive = true
    ): ProductInterface {
        $product = $this->createProduct($productCode);

        $productInformation = $this->createProductInformation($product->getId(), $locale);
        $productInformation->setName($productName);

        if ($createLive) {
            $productInformationLive = $this->createProductInformationLive($product->getId(), $locale);
            $productInformationLive->setName($productName);
        }

        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();

        if ($createLive) {
            $publishMessage = new PublishProductMessage($product->getId(), 'en');
            $this->getMessageBus()->dispatch($publishMessage);
        }

        return $product;
    }

    private function getMessageBus(): MessageBusInterface
    {
        /** @var MessageBus $messageBus */
        $messageBus = $this->getContainer()->get('message_bus');

        return $messageBus;
    }
}
