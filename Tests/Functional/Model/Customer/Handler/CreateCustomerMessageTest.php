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

use GuzzleHttp\Psr7\Response;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Message\CreateCustomerMessage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Service\GatewayClient;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateCustomerMessageTest extends SuluTestCase
{
    public function setUp()
    {
        $this->purgeDatabase();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testMin(): void
    {
        $this->getGatewayClient()->setHandleRequestCallable(
            function($method, $uri, array $options = []) {
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
                            "enabled": false,
                            "token": "72FThg24HeesEPbM"
                        }
                    }'
                );
            }
        );

        $message = new CreateCustomerMessage(
            'test@test.com',
            'super-password-123',
            'first name',
            'last name',
            'm'
        );

        $result = $this->getMessageBus()->dispatch($message);

        $this->assertCount(4, $result);
    }

    private function getGatewayClient(): GatewayClient
    {
        /** @var GatewayClient $gatewayClient */
        $gatewayClient = $this->getContainer()->get('sulu_sylius_consumer.gateway_client');

        return $gatewayClient;
    }

    private function getMessageBus(): MessageBusInterface
    {
        /** @var MessageBus $messageBus */
        $messageBus = $this->getContainer()->get('message_bus');

        return $messageBus;
    }
}
