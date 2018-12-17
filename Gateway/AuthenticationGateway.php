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
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Factory\CustomerFactory;

class AuthenticationGateway extends AbstractGateway implements AuthenticationGatewayInterface
{
    const URI = '/api/v1/authenticate';

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    public function __construct(ClientInterface $gatewayClient, CustomerFactory $customerFactory)
    {
        parent::__construct($gatewayClient);

        $this->customerFactory = $customerFactory;
    }

    public function getCustomer(string $email, string $password): ?Customer
    {
        $response = $this->sendRequest(
            'GET',
            self::URI,
            [
                'query' => [
                    'email' => $email,
                    'password' => $password,
                ],
            ]
        );

        if (400 === $response->getStatusCode()) {
            return null;
        }

        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->customerFactory->createFromArray($this->getData($response));
    }
}
