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
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ProductTrait;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class ProductControllerTest extends SuluTestCase
{
    use ProductTrait;

    public function setUp()
    {
        $this->purgeDatabase();
    }

    public function testGetAction(): void
    {
        $product = $this->createProduct('product-1');

        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/products/' . $product->getCode());

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($product->getCode(), $response['code']);
    }

    public function testCGetAction(): void
    {
        $product = $this->createProduct('product-1');

        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/products');

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertCount(1, $response['_embedded'][ProductInterface::RESOURCE_KEY]);
        $this->assertEquals($product->getCode(), $response['_embedded'][ProductInterface::RESOURCE_KEY][0]['code']);
    }
}
