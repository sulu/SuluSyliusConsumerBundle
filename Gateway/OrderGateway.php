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

class OrderGateway extends AbstractGateway implements OrderGatewayInterface
{
    const URI = '/api/v1/orders';

    public function findById(int $id): array
    {
        $response = $this->sendRequest(
            'GET',
            self::URI . '/' . $id . '/'
        );

        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->getData($response);
    }

    public function findByCustomer(
        int $customerId,
        int $limit = 10,
        int $page = 1,
        ?\DateTime $from = null,
        ?\DateTime $to = null,
        bool $inclusiveFrom = true,
        bool $inclusiveTo = false
    ): array {
        $criteria = [
            'customer' => [
                'type' => 'equal',
                'value' => $customerId,
            ],
        ];

        if ($from) {
            $criteria['date'] = [];

            $criteria['date']['from'] = [
                'date' => $from->format('Y-m-d'),
                'time' => $from->format('H:i:s'),
                'inclusive_from' => $inclusiveFrom,
            ];
        }

        if ($to) {
            if (!array_key_exists('date', $criteria)) {
                $criteria['date'] = [];
            }

            $criteria['date']['to'] = [
                'date' => $to->format('Y-m-d'),
                'time' => $to->format('H:i:s'),
                'inclusive_to' => $inclusiveTo,
            ];
        }

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
}
