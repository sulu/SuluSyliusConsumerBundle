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
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class ProductControllerTest extends SuluTestCase
{
    use DimensionTrait;
    use ProductInformationTrait;

    public function setUp()
    {
        $this->purgeDatabase();
    }

    public function testGetAction(): void
    {
        $product = $this->createProductInformation('product-1', 'en');
        $product->setName('Product One');
        $this->getEntityManager()->flush();

        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/products/' . $product->getCode() . '?locale=en');

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($product->getCode(), $response['code']);
        $this->assertEquals($product->getName(), $response['name']);
    }

    public function testCGetAction(): void
    {
        $product1 = $this->createProductInformation('product-1', 'en');
        $product1->setName('Product One');
        $this->getEntityManager()->flush();

        $product2 = $this->createProductInformation('product-1', 'de');
        $product2->setName('Produkt Eins');
        $this->getEntityManager()->flush();

        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/products?locale=en');

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertCount(1, $response['_embedded'][ProductInterface::RESOURCE_KEY]);
        $this->assertEquals($product1->getCode(), $response['_embedded'][ProductInterface::RESOURCE_KEY][0]['code']);
        $this->assertEquals($product1->getName(), $response['_embedded'][ProductInterface::RESOURCE_KEY][0]['name']);
    }
}
