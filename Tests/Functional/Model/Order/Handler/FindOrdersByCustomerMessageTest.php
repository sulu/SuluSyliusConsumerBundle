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
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\Query\FindOrdersByCustomerMessage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Service\GatewayClient;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class FindOrdersByCustomerMessageTest extends SuluTestCase
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
                return new Response(
                    200,
                    [],
                    '{
                        "page": 1,
                        "limit": 10,
                        "pages": 1,
                        "total": 1,
                        "_embedded": {
                            "items": [
                                {
                                    "id": 5,
                                },
                                {
                                    "id": 6,
                                }
                            ]
                        }
                    }'
                );
            }
        );

        $customer = new Customer(1, 'test@test.com', 'test@test.com', 'm');

        $message = new FindOrdersByCustomerMessage($customer);

        // send message
        $this->getMessageBus()->dispatch($message);
        $orderList = $message->getOrderList();

        $this->assertSame(1, $orderList->getPage());
        $this->assertSame(10, $orderList->getLimit());
        $this->assertSame(1, $orderList->getPages());
        $this->assertSame(1, $orderList->getTotal());
        $this->assertSame([['id' => 5], ['id' => 6]], $orderList->getOrders());
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
