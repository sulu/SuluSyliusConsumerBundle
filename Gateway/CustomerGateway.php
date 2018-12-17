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
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Customer;
use Sulu\Bundle\SyliusConsumerBundle\Model\Customer\Factory\CustomerFactory;

class CustomerGateway extends AbstractGateway implements CustomerGatewayInterface
{
    const URI = '/api/v1/customers';

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    public function __construct(
        ClientInterface $gatewayClient,
        CustomerFactory $customerFactory
    ) {
        parent::__construct($gatewayClient);
        $this->customerFactory = $customerFactory;
    }

    public function findById(int $id): Customer
    {
        $response = $this->sendRequest(
            'GET',
            self::URI . '/' . $id
        );

        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->customerFactory->createFromArray($this->getData($response));
    }

    public function create(
        string $email,
        string $plainPassword,
        string $firstName,
        string $lastName,
        string $gender,
        bool $enabled = false
    ): Customer {
        $response = $this->sendRequest(
            'POST',
            self::URI . '/',
            [
                RequestOptions::JSON => [
                    'email' => $email,
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'gender' => $gender,
                    'user' => [
                        'plainPassword' => $plainPassword,
                        'enabled' => $enabled,
                    ]
                ],
            ]
        );

        if (201 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->customerFactory->createFromArray($this->getData($response));
    }

    public function modify(
        string $email,
        ?string $plainPassword = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $gender = null,
        ?bool $enabled = null
    ): void {
        $data = [
            'email' => $email,
        ];

        if (null !== $firstName) {
            $data['firstName'] = $firstName;
        }

        if (null !== $lastName) {
            $data['lastName'] = $lastName;
        }

        if (null !== $gender) {
            $data['gender'] = $gender;
        }

        if (null !== $plainPassword || null !== $enabled) {
            $data['user'] = [];

            if (null !== $plainPassword) {
                $data['user']['plainPassword'] = $plainPassword;
            }
            if (null !== $enabled) {
                $data['user']['enabled'] = $enabled;
            }
        }

        $response = $this->sendRequest(
            'PATCH',
            self::URI . '/',
            [
                RequestOptions::JSON => $data,
            ]
        );

        if (204 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }
    }

    public function verify(string $token): Customer
    {
        $response = $this->sendRequest('PUT', '/api/v1/verify/' . $token);

        if (200 !== $response->getStatusCode()) {
            $this->handleErrors($response);
        }

        return $this->customerFactory->createFromArray($this->getData($response));
    }
}
