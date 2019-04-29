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

use GuzzleHttp\RequestOptions;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressInterface;

class AddressGateway extends AbstractGateway implements AddressGatewayInterface
{
    const URI = '/api/v1/addresses';

    public function findByCustomer(int $customerId, int $limit = 10, int $page = 1): array
    {
        $criteria = [
            'customerId' => [
                'type' => 'equal',
                'value' => $customerId,
            ],
        ];

        $queryOptions = [
            'limit' => $limit,
            'page' => $page,
            'criteria' => $criteria,
        ];

        $response = $this->sendRequest(
            'GET',
            self::URI . '/',
            [
                RequestOptions::QUERY => $queryOptions,
            ]
        );

        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->getData($response);
    }

    public function findById(int $id): array
    {
        $response = $this->sendRequest(
            'GET',
            self::URI . '/' . $id
        );

        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->getData($response);
    }

    public function create(int $customerId, AddressInterface $address): array
    {
        $json = $address->toArray();
        $json['customer'] = $customerId;

        $response = $this->sendRequest(
            'POST',
            self::URI . '/',
            [
                RequestOptions::JSON => $json,
            ]
        );

        if (201 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->getData($response);
    }

    public function update(AddressInterface $address): void
    {
        if (!$address->getId()) {
            throw new \RuntimeException('Given address has no id');
        }

        $response = $this->sendRequest(
            'PUT',
            self::URI . '/' . $address->getId(),
            [
                RequestOptions::JSON => $address->toArray(),
            ]
        );

        if (204 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
    }

    public function remove(int $id): void
    {
        $response = $this->sendRequest('DELETE', self::URI . '/' . $id);

        if (204 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
    }
}
