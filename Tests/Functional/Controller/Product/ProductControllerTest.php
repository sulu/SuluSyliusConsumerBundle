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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Controller\Product;

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInterface;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\DimensionTrait;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductInformationTrait;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductTrait;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class ProductControllerTest extends SuluTestCase
{
    use DimensionTrait;
    use ProductInformationTrait;
    use ProductTrait;

    public function setUp()
    {
        $this->purgeDatabase();
    }

    public function testGetAction(): void
    {
        $product = $this->createProduct('product-1');
        $productInformation = $this->createProductInformation($product->getId(), 'en');
        $productInformation->setName('Product One');
        $this->getEntityManager()->flush();

        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/products/' . $productInformation->getProductId() . '?locale=en');

        $response = json_decode((string) $client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($productInformation->getProductId(), $response['id']);
        $this->assertEquals($productInformation->getName(), $response['name']);
    }

    public function testCGetAction(): void
    {
        $product = $this->createProduct('product-1');
        $productInformation1 = $this->createProductInformation($product->getId(), 'en');
        $productInformation1->setName('Product One');
        $this->getEntityManager()->flush();

        $productInformation2 = $this->createProductInformation($product->getId(), 'de');
        $productInformation2->setName('Produkt Eins');
        $this->getEntityManager()->flush();

        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/products?locale=en');

        $response = json_decode((string) $client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertCount(1, $response['_embedded'][ProductInterface::RESOURCE_KEY]);
        $this->assertEquals($productInformation1->getProductId(), $response['_embedded'][ProductInterface::RESOURCE_KEY][0]['id']);
        $this->assertEquals($productInformation1->getName(), $response['_embedded'][ProductInterface::RESOURCE_KEY][0]['name']);
    }
}
