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
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Query\FindAddressQuery;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\FunctionalTestCase;

class FindAddressQueryTest extends FunctionalTestCase
{
    public function testMessage(): void
    {
        $this->getGatewayClient()->setHandleRequestCallable(
            function ($method, $uri, array $options = []) {
                $this->assertEquals('GET', $method);
                $this->assertEquals('/api/v1/addresses/99', $uri);

                return new Response(
                    200,
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

        $message = new FindAddressQuery(99);

        // send message
        $this->getMessageBus()->dispatch($message);

        $address = $message->getAddress();
        $this->assertEquals('23', $address->getId());
        $this->assertEquals('Elon', $address->getFirstName());
        $this->assertEquals('Musk', $address->getLastName());
        $this->assertEquals('10941 Savona Rd', $address->getStreet());
        $this->assertEquals('CA 900077', $address->getPostcode());
        $this->assertEquals('Los Angeles', $address->getCity());
        $this->assertEquals('US', $address->getCountryCode());
        $this->assertNull($address->getProvinceCode());
        $this->assertNull($address->getPhoneNumber());
    }
}
