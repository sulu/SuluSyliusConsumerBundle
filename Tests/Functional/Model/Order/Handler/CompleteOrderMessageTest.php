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
use Sulu\Bundle\SyliusConsumerBundle\Tests\Service\GatewayClient;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class CompleteOrderMessageTest extends SuluTestCase
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
                $this->assertEquals('PUT', $method);
                $this->assertEquals('/api/v1/checkouts/complete/21', $uri);

                return new Response(204, []);
            }
        );

        $message = new CompleteOrderMessage(21);

        // send message
        $this->getMessageBus()->dispatch($message);
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
