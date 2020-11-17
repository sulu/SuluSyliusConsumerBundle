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
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends SuluTestCase
{
    use DimensionTrait;
    use ProductInformationTrait;
    use ProductTrait;

    /**
     * @var KernelBrowser
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = $this->createAuthenticatedClient();
        $this->purgeDatabase();
    }

    public function testGetAction(): void
    {
        $product = $this->createProduct('product-1');
        $productInformation = $this->createProductInformation($product->getId(), 'en');
        $productInformation->setName('Product One');
        $this->getEntityManager()->flush();

        $this->client->request('GET', '/api/products/' . $productInformation->getProductId() . '?locale=en');

        /** @var Response $response */
        $response = $this->client->getResponse();
        $this->assertInstanceOf(Response::class, $response);
        $result = json_decode((string) $response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals($productInformation->getProductId(), $result['id']);
        $this->assertEquals($productInformation->getName(), $result['name']);
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

        $this->client->request('GET', '/api/products?locale=en');

        /** @var Response $response */
        $response = $this->client->getResponse();
        $this->assertInstanceOf(Response::class, $response);
        $result = json_decode((string) $response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertCount(1, $result['_embedded'][ProductInterface::RESOURCE_KEY]);
        $this->assertEquals($productInformation1->getProductId(), $result['_embedded'][ProductInterface::RESOURCE_KEY][0]['id']);
        $this->assertEquals($productInformation1->getName(), $result['_embedded'][ProductInterface::RESOURCE_KEY][0]['name']);
    }

    public function testCGetActionWithIds(): void
    {
        $product = $this->createProduct('product-1');
        $productInformation1 = $this->createProductInformation($product->getId(), 'en');
        $productInformation1->setName('Product One');
        $this->getEntityManager()->flush();

        $product2 = $this->createProduct('product-2');
        $productInformation2 = $this->createProductInformation($product2->getId(), 'en');
        $productInformation2->setName('Product Two');
        $this->getEntityManager()->flush();

        $this->client->request('GET', '/api/products?locale=en&ids=' . $product2->getId() . ',' . $product->getId());

        /** @var Response $response */
        $response = $this->client->getResponse();
        $this->assertInstanceOf(Response::class, $response);
        $result = json_decode((string) $response->getContent(), true);
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertCount(2, $result['_embedded'][ProductInterface::RESOURCE_KEY]);
        $this->assertEquals($productInformation2->getProductId(), $result['_embedded'][ProductInterface::RESOURCE_KEY][0]['id']);
        $this->assertEquals($productInformation2->getName(), $result['_embedded'][ProductInterface::RESOURCE_KEY][0]['name']);
        $this->assertEquals($productInformation1->getProductId(), $result['_embedded'][ProductInterface::RESOURCE_KEY][1]['id']);
        $this->assertEquals($productInformation1->getName(), $result['_embedded'][ProductInterface::RESOURCE_KEY][1]['name']);
    }
}
