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

class CartGateway implements CartGatewayInterface
{
    const URI = '/api/v1/carts';

    /**
     * @var ClientInterface
     */
    private $gatewayClient;

    public function __construct(ClientInterface $gatewayClient)
    {
        $this->gatewayClient = $gatewayClient;
    }

    public function findById(int $id): array
    {
        $response = $this->gatewayClient->request(
            'GET',
            self::URI . '/' . $id
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function findByCustomerEmail(string $customerEmail): array
    {
        $response = $this->gatewayClient->request(
            'GET',
            self::URI,
            [
                RequestOptions::QUERY => [
                    'criteria[customer][type]' => 'equal',
                    'criteria[customer][value]' => $customerEmail,
                ],
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if (!$data['_embedded']['items'] || count($data['_embedded']['items']) < 1) {
            return [];
        }

        return $data['_embedded']['items'][0];
    }

    public function create(string $customer, string $channel, string $locale): array
    {
        $response = $this->gatewayClient->request(
            'POST',
            self::URI . '/',
            [
                RequestOptions::JSON => [
                    'customer' => $customer,
                    'channel' => $channel,
                    'localeCode' => $locale,
                ]
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function remove(int $id): array
    {
        $response = $this->gatewayClient->request('DELETE', self::URI . '/' . $id);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function addItem(int $cartId, string $variantCode, int $quantity): array
    {
        $response = $this->gatewayClient->request(
            'POST',
            self::URI . '/' . $cartId . '/items',
            [
                [
                    RequestOptions::JSON => [
                        'variantCode' => $variantCode,
                        'quantity' => $quantity,
                    ]
                ]
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function modifyItem(int $cartId, int $cartItemId, int $quantity): array
    {
        $response = $this->gatewayClient->request(
            'PUT',
            self::URI . '/' . $cartId . '/' . $cartItemId,
            [
                [
                    RequestOptions::JSON => [
                        'quantity' => $quantity,
                    ]
                ]
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function removeItem(int $cartId, int $cartItemId): array
    {
        $response = $this->gatewayClient->request(
            'DELETE',
            self::URI . '/' . $cartId . '/' . $cartItemId
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
