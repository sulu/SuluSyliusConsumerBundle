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
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Message\CreateCustomerMessage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Service\GatewayClient;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;
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
                    201,
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

        $messageLogger = $this->createAndRegisterMessageLogger();

        $message = new CreateCustomerMessage(
            'test@test.com',
            'super-password-123',
            'John',
            'Diggle',
            'm'
        );

        // send message
        $result = $this->getMessageBus()->dispatch($message);

        // check result
        $this->assertInstanceOf(Customer::class, $result);

        // checks that an email was sent
        $this->assertSame(1, $messageLogger->countMessages());
        $message = $messageLogger->getMessages()[0];

        // Asserting email data
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertSame('Verify your email address', $message->getSubject());
        $this->assertSame('no-reply@example.com', key($message->getFrom()));
        $this->assertSame('test@test.com', key($message->getTo()));
        $this->assertContains(
            'http://localhost/verify/72FThg24HeesEPbM',
            $message->getBody()
        );
    }

    private function createAndRegisterMessageLogger(): \Swift_Plugins_MessageLogger
    {
        // register swiftmailer logger
        $mailer = $this->getContainer()->get('mailer');
        $logger = new \Swift_Plugins_MessageLogger();
        $mailer->registerPlugin($logger);

        return $logger;
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
