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

class ProductAttributeGateway implements ProductAttributeGatewayInterface
{
    const URI = '/api/v1/product-attributes/';

    /**
     * @var ClientInterface
     */
    private $gatewayClient;

    public function __construct(ClientInterface $gatewayClient)
    {
        $this->gatewayClient = $gatewayClient;
    }

    public function findByCode(string $code): array
    {
        $response = $this->gatewayClient->request(
            'GET',
            self::URI . $code
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function findByCodes(array $codes): array
    {
        $response = $this->gatewayClient->request(
            'GET',
            self::URI,
            [
                RequestOptions::QUERY => [
                    'criteria' => [
                        'code' => [
                            'type' => 'in',
                            'value' => implode(',', $codes),
                        ],
                    ],
                    'limit' => count($codes),
                ],
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if (!$data['_embedded']['items'] || count($data['_embedded']['items']) < 1) {
            return [];
        }

        return $data['_embedded']['items'];
    }
}
