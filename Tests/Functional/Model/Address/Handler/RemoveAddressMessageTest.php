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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Model\Address\Handler;

use GuzzleHttp\Psr7\Response;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Message\RemoveAddressMessage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Service\GatewayClient;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class RemoveAddressMessageTest extends SuluTestCase
{
    public function testMessage(): void
    {
        $this->getGatewayClient()->setHandleRequestCallable(
            function ($method, $uri, array $options = []) {
                $this->assertEquals('DELETE', $method);
                $this->assertEquals('/api/v1/addresses/99', $uri);

                return new Response(204);
            }
        );

        $message = new RemoveAddressMessage(99);

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
