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

class CartGateway
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

    public function get(int $id): array
    {
        $response = $this->gatewayClient->request(
            'GET',
            self::URI . '/' . $id
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function create(string $customer, string $channel, string $locale): array
    {
        $response = $this->gatewayClient->request(
            'POST',
            self::URI,
            [
                'customer' => $customer,
                'channel' => $channel,
                'locale' => $locale,
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function delete(int $id): array
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
                'variantCode' => $variantCode,
                'quantity' => $quantity,
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function updateItem(int $cartId, int $cartItemId, int $quantity): array
    {
        $response = $this->gatewayClient->request(
            'PUT',
            self::URI . '/' . $cartId . '/' . $cartItemId,
            [
                'quantity' => $quantity,
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function deleteItem(int $cartId, int $cartItemId): array
    {
        $response = $this->gatewayClient->request(
            'DELETE',
            self::URI . '/' . $cartId . '/' . $cartItemId
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
