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
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CustomerControllerTest extends SuluTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = $this->createWebsiteClient();
        parent::setUp();
    }

    public function testVerify(): void
    {
        $this->getGatewayClient($this->client)->setHandleRequestCallable(
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

        $this->client->request('GET', '/verify/123-123-123');

        /** @var SymfonyResponse $response */
        $response = $this->client->getResponse();
        $this->assertInstanceOf(SymfonyResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode());

        $token = $this->getToken($this->client);
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

    private function getToken(KernelBrowser $client): ?TokenInterface
    {
        return $client->getContainer()->get('security.token_storage')->getToken();
    }

    private function getGatewayClient(KernelBrowser $client): GatewayClient
    {
        /** @var GatewayClient $gatewayClient */
        $gatewayClient = $client->getContainer()->get('sulu_sylius_consumer.gateway_client');

        return $gatewayClient;
    }
}
