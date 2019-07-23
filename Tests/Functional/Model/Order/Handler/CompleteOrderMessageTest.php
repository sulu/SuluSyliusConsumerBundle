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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Model\Order\Handler;

use GuzzleHttp\Psr7\Response;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\Message\CompleteOrderMessage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\FunctionalTestCase;

class CompleteOrderMessageTest extends FunctionalTestCase
{
    public function setUp()
    {
        $this->purgeDatabase();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function getKernelConfiguration()
    {
        return ['sulu_context' => 'website'];
    }

    public function testMin(): void
    {
        $this->getGatewayClient()->setHandleRequestCallable(
            function ($method, $uri, array $options = []) {
                if ('PUT' === $method) {
                    $this->assertEquals('/api/v1/checkouts/complete/21', $uri);

                    return new Response(204);
                }
                if ('GET' === $method) {
                    $this->assertEquals('/api/v1/orders/21/', $uri);

                    return new Response(
                        200,
                        [],
                        '{
                            "id": 55,
                            "customer": {
                                "id": 1,
                                "email": "test@test.com",
                                "emailCanonical": "test@test.com",
                                "firstName": "John",
                                "lastName": "Doe",
                                "gender": "u",
                                "group": {
                                    "id": 1,
                                    "code": "retail",
                                    "name": "Retail"
                                },
                                "user": {
                                    "id": 1,
                                    "username": "shop@example.com",
                                    "usernameCanonical": "shop@example.com",
                                    "roles": [
                                        "ROLE_USER"
                                    ],
                                    "enabled": true,
                                    "token": null,
                                    "hash": "76fada94173cea244655e931934554eb32579d17"
                                },
                                "_links": {
                                    "self": {
                                        "href": "/api/v1/customers/1"
                                    }
                                }
                            }
                        }'
                    );
                }

                throw new \RuntimeException('Unexpected GatewayClient call');
            }
        );

        $messageLogger = $this->createAndRegisterMessageLogger();

        $message = new CompleteOrderMessage(21);

        // send message
        $this->getMessageBus()->dispatch($message);

        // checks that an email was sent
        $this->assertSame(1, $messageLogger->countMessages());
        $message = $messageLogger->getMessages()[0];

        // Asserting email data
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertSame('Order confirmation', $message->getSubject());
        $this->assertSame('no-reply@example.com', key($message->getFrom()));
        $this->assertSame('test@test.com', key($message->getTo()));
        $this->assertContains(
            'Your order no. 55 has been successfully placed',
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
}
