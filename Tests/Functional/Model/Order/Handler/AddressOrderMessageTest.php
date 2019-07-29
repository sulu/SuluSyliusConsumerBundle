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
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Address;
use Sulu\Bundle\SyliusConsumerBundle\Model\Order\Message\AddressOrderMessage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\GatewayClientTestCase;

class AddressOrderMessageTest extends GatewayClientTestCase
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
                $this->assertEquals('/api/v1/checkouts/addressing/21', $uri);
                $this->assertEquals(
                    [
                        'differentBillingAddress' => false,
                        'shippingAddress' => [
                            'firstName' => 'Elon',
                            'lastName' => 'Musk',
                            'street' => '10941 Savona Rd',
                            'postcode' => 'CA 900077',
                            'city' => 'Los Angeles',
                            'countryCode' => 'US',
                        ],
                    ],
                    $options['json']
                );

                return new Response(204, []);
            }
        );

        $orderId = 21;
        $shippingAddress = new Address(null, 'Elon', 'Musk', '10941 Savona Rd', 'CA 900077', 'Los Angeles', 'US');

        $message = new AddressOrderMessage($orderId, $shippingAddress);

        // send message
        $this->getMessageBus()->dispatch($message);
    }

    public function testMax(): void
    {
        $this->getGatewayClient()->setHandleRequestCallable(
            function ($method, $uri, array $options = []) {
                $this->assertEquals('PUT', $method);
                $this->assertEquals('/api/v1/checkouts/addressing/21', $uri);
                $this->assertEquals(
                    [
                        'differentBillingAddress' => true,
                        'shippingAddress' => [
                            'firstName' => 'Elon',
                            'lastName' => 'Musk',
                            'street' => '10941 Savona Rd',
                            'postcode' => 'CA 900077',
                            'city' => 'Los Angeles',
                            'countryCode' => 'US',
                        ],
                        'billingAddress' => [
                            'firstName' => 'Elon',
                            'lastName' => 'Musk',
                            'street' => 'Tesla Street 123',
                            'postcode' => 'CA 900077',
                            'city' => 'Los Angeles',
                            'countryCode' => 'US',
                        ],
                    ],
                    $options['json']
                );

                return new Response(204, []);
            }
        );

        $orderId = 21;
        $shippingAddress = new Address(null, 'Elon', 'Musk', '10941 Savona Rd', 'CA 900077', 'Los Angeles', 'US');
        $billingAddress = new Address(null, 'Elon', 'Musk', 'Tesla Street 123', 'CA 900077', 'Los Angeles', 'US');

        $message = new AddressOrderMessage($orderId, $shippingAddress, $billingAddress);

        // send message
        $this->getMessageBus()->dispatch($message);
    }
}
