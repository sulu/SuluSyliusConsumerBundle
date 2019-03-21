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
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Address;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Message\CreateAddressMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Service\GatewayClient;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateAddressMessageTest extends SuluTestCase
{
    public function testMessage(): void
    {
        $this->getGatewayClient()->setHandleRequestCallable(
            function ($method, $uri, array $options = []) {
                $this->assertEquals('POST', $method);
                $this->assertEquals('/api/v1/addresses/', $uri);
                $this->assertEquals(
                    [
                        'customer' => 99,
                        'firstName' => 'Elon',
                        'lastName' => 'Musk',
                        'street' => '10941 Savona Rd',
                        'postcode' => 'CA 900077',
                        'city' => 'Los Angeles',
                        'countryCode' => 'US',
                    ],
                    $options['json']
                );

                return new Response(
                    201,
                    [],
                    '{
                        "id": 23,
                        "firstName": "Elon",
                        "lastName": "Musk",
                        "street": "10941 Savona Rd",
                        "postcode": "CA 900077",
                        "city": "Los Angeles",
                        "countryCode": "US"
                    }'
                );
            }
        );

        $customer = new Customer(99, 'test@test.com', 'test@test.com', 'm');
        $address = new Address(null, 'Elon', 'Musk', '10941 Savona Rd', 'CA 900077', 'Los Angeles', 'US');

        $message = new CreateAddressMessage($customer, $address);

        // send message
        $this->getMessageBus()->dispatch($message);

        $result = $message->getResult();
        $this->assertEquals('23', $result->getId());
        $this->assertEquals($address->getFirstName(), $result->getFirstName());
        $this->assertEquals($address->getLastName(), $result->getLastName());
        $this->assertEquals($address->getStreet(), $result->getStreet());
        $this->assertEquals($address->getPostcode(), $result->getPostcode());
        $this->assertEquals($address->getCity(), $result->getCity());
        $this->assertEquals($address->getCountryCode(), $result->getCountryCode());
        $this->assertEquals($address->getProvinceCode(), $result->getProvinceCode());
        $this->assertEquals($address->getPhoneNumber(), $result->getPhoneNumber());
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
