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

class ProductVariantChannelPricingGateway extends AbstractGateway
    implements ProductVariantChannelPricingGatewayInterface
{
    const URI = '/api/v1/products/{PRODUCE_ID}/variants/';

    public function findByCodeAndVariant(string $code, string $variantCode): array
    {
        $response = $this->gatewayClient->request(
            'GET',
            str_replace('{PRODUCE_ID}', $code, self::URI) . $variantCode
        );

        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['channelPricings'];
    }
}
