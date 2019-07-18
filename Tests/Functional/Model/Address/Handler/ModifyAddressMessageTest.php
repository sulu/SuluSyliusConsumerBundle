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
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Message\ModifyAddressMessage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\FunctionalTestCate;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Service\GatewayClient;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class ModifyAddressMessageTest extends FunctionalTestCate
{
    public function testMessage(): void
    {
        $this->getGatewayClient()->setHandleRequestCallable(
            function ($method, $uri, array $options = []) {
                $this->assertEquals('PUT', $method);
                $this->assertEquals('/api/v1/addresses/99', $uri);
                $this->assertEquals(
                    [
                        'firstName' => 'Elon',
                        'lastName' => 'Musk',
                        'street' => '10941 Savona Rd',
                        'postcode' => 'CA 900077',
                        'city' => 'Los Angeles',
                        'countryCode' => 'US',
                    ],
                    $options['json']
                );

                return new Response(204);
            }
        );

        $address = new Address(99, 'Elon', 'Musk', '10941 Savona Rd', 'CA 900077', 'Los Angeles', 'US');

        $message = new ModifyAddressMessage($address);

        // send message
        $this->getMessageBus()->dispatch($message);
    }
}
