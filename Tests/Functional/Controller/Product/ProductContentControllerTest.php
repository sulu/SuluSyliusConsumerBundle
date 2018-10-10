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

use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\ContentTrait;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class ProductContentControllerTest extends SuluTestCase
{
    use ContentTrait;

    public function setUp()
    {
        $this->purgeDatabase();
    }

    public function testGetAction(): void
    {
        $content = $this->createContent('products', 'product-1');

        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/product-contents/' . $content->getResourceId());

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(
            array_merge(['template' => $content->getType()], $content->getData()),
            $response
        );
    }

    public function testPutActionCreate(): void
    {
        $data = ['template' => 'default', 'title' => 'Sulu is awesome'];

        $client = $this->createAuthenticatedClient();
        $client->request('PUT', '/api/product-contents/product-1', $data);

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($data, $response);
    }

    public function testPutActionUpdate(): void
    {
        $content = $this->createContent('products', 'product-1', 'homepage', ['title' => 'Sulu is great']);

        $data = ['template' => 'default', 'title' => 'Sulu is awesome'];

        $client = $this->createAuthenticatedClient();
        $client->request('PUT', '/api/product-contents/' . $content->getResourceId(), $data);

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($data, $response);
    }
}
