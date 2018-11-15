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
use Sulu\Bundle\SyliusConsumerBundle\Security\SyliusUser;

class AuthenticationGateway
{
    /**
     * @var ClientInterface
     */
    private $gatewayClient;

    public function __construct(ClientInterface $gatewayClient)
    {
        $this->gatewayClient = $gatewayClient;
    }

    public function getUser(string $email, string $password): ?SyliusUser
    {
        $response = $this->gatewayClient->request(
            'GET',
            '/api/sulu-user',
            [
                'query' => ['email' => $email, 'password' => $password],
            ]
        );

        $data = json_encode($response->getBody()->getContents());
        if (!$data) {
            return null;
        }

        return new SyliusUser(
            $data['id'],
            $data['username'],
            $data['roles'],
            $data['email'],
            $data['firstName'],
            $data['lastName'],
        );
    }
}
