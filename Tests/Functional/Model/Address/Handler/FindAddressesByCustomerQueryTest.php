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
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Query\FindAddressesByCustomerQuery;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Service\GatewayClient;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class FindAddressesByCustomerQueryTest extends SuluTestCase
{
    public function testMessage(): void
    {
        $this->getGatewayClient()->setHandleRequestCallable(
            function ($method, $uri, array $options = []) {
                $this->assertEquals('GET', $method);
                $this->assertEquals('/api/v1/addresses/', $uri);
                $this->assertEquals(
                    [
                        'limit' => 10,
                        'page' => 1,
                        'criteria' => [
                            'customer' => [
                                'type' => 'equal',
                                'value' => 99,
                            ],
                        ],
                    ],
                    $options['query']
                );

                return new Response(
                    200,
                    [],
                    '{
                        "page": 1,
                        "limit": 10,
                        "pages": 1,
                        "total": 2,
                        "_embedded": {
                            "items": [
                                {
                                    "id": 23,
                                    "firstName": "Elon",
                                    "lastName": "Musk",
                                    "street": "10941 Savona Rd",
                                    "postcode": "CA 900077",
                                    "city": "Los Angeles",
                                    "countryCode": "US"
                                },
                                {
                                    "id": 27,
                                    "firstName": "John",
                                    "lastName": "Travolat",
                                    "street": "JT Street",
                                    "postcode": "CA 900077",
                                    "city": "Hollywood",
                                    "countryCode": "US"
                                }
                            ]
                        }
                    }'
                );
            }
        );

        $customer = new Customer(99, 'test@test.com', 'test@test.com', 'm');
        $message = new FindAddressesByCustomerQuery($customer);

        // send message
        $this->getMessageBus()->dispatch($message);

        $addressList = $message->getAddressList();
        $this->assertSame(1, $addressList->getPage());
        $this->assertSame(10, $addressList->getLimit());
        $this->assertSame(1, $addressList->getPages());
        $this->assertSame(2, $addressList->getTotal());
        $this->assertCount(2, $addressList->getAddresses());
        $this->assertInstanceOf(AddressInterface::class, $addressList->getAddresses()[0]);
        $this->assertInstanceOf(AddressInterface::class, $addressList->getAddresses()[1]);
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
