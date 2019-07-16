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

namespace Sulu\Bundle\SyliusConsumerBundle\Gateway;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

class ProductChannelPricingGateway implements ProductChannelPricingGatewayInterface
{
    const URI = '/api/v1/product/{PRODUCE_ID}/variants';

    /**
     * @var ClientInterface
     */
    private $gatewayClient;

    public function __construct(ClientInterface $gatewayClient)
    {
        $this->gatewayClient = $gatewayClient;
    }

    public function findByCodeAndChannel(string $code, string $channel): array
    {
        $response = $this->gatewayClient->request(
            'GET',
            str_replace('{PRODUCE_ID}', $code, self::URI)
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
