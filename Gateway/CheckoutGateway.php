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

class CheckoutGateway extends AbstractGateway implements CheckoutGatewayInterface
{
    const URI = '/api/v1/checkouts';

    public function addressing(
        int $orderId,
        AddressInterface $shippingAddress,
        ?AddressInterface $billingAddress = null
    ): void {
        $data = [
            'differentBillingAddress' => false,
            'shippingAddress' => $shippingAddress->toArray(),
        ];

        if ($billingAddress) {
            $data['differentBillingAddress'] = true;
            $data['billingAddress'] = $billingAddress->toArray();
        }

        $response = $this->sendRequest(
            'PUT',
            self::URI . '/addressing/' . $orderId,
            [
                RequestOptions::JSON => $data,
            ]
        );

        if (204 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
    }

    public function complete(int $orderId): void
    {
        $response = $this->sendRequest(
            'PUT',
            self::URI . '/complete/' . $orderId
        );

        if (204 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
    }
}
