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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Controller\Customer;

use GuzzleHttp\Psr7\Response;
use Sulu\Bundle\SyliusConsumerBundle\Security\SyliusUser;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Service\GatewayClient;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CustomerControllerTest extends SuluTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testVerify(): void
    {
        $client = $this->createWebsiteClient();

        $this->getGatewayClient($client)->setHandleRequestCallable(
            function ($method, $uri, array $options = []) {
                return new Response(
                    200,
                    [],
                    '{
                        "id": 564,
                        "email": "test@test.com",
                        "emailCanonical": "test@test.com",
                        "firstName": "John",
                        "lastName": "Diggle",
                        "gender": "m",
                        "user": {
                            "id": 13619,
                            "roles": [
                                "ROLE_USER"
                            ],
                            "enabled": true,
                            "token": null,
                            "hash": "afjkasd-jfkladf-123jkfasd-123"
                        }
                    }'
                );
            }
        );

        $client->request('GET', '/verify/123-123-123');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $token = $this->getToken($client);
        $this->assertNotNull($token);
        if (!$token) {
            return;
        }

        /** @var SyliusUser $user */
        $user = $token->getUser();
        $this->assertInstanceOf(SyliusUser::class, $user);
        $this->assertEquals('test@test.com', $user->getUsername());
        $this->assertEquals('John', $user->getCustomer()->getFirstName());
        $this->assertEquals('Diggle', $user->getCustomer()->getLastName());
        $this->assertTrue($user->getCustomer()->getUser()->isEnabled());
    }

    private function getToken(Client $client): ?TokenInterface
    {
        $container = $client->getContainer();
        if (!$container) {
            throw new \RuntimeException('Container is missing');
        }

        return $container->get('security.token_storage')->getToken();
    }

    private function getGatewayClient(Client $client): GatewayClient
    {
        $container = $client->getContainer();
        if (!$container) {
            throw new \RuntimeException('Container is missing');
        }

        /** @var GatewayClient $gatewayClient */
        $gatewayClient = $container->get('sulu_sylius_consumer.gateway_client');

        return $gatewayClient;
    }
}
