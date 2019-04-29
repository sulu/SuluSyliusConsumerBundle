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
use Psr\Http\Message\ResponseInterface;
use Sulu\Bundle\SyliusConsumerBundle\Gateway\Exception\NotFoundException;
use Sulu\Bundle\SyliusConsumerBundle\Gateway\Exception\UnauthorizedException;
use Sulu\Bundle\SyliusConsumerBundle\Gateway\Exception\UnknownErrorException;
use Sulu\Bundle\SyliusConsumerBundle\Gateway\Exception\ValidationException;

abstract class AbstractGateway
{
    /**
     * @var ClientInterface
     */
    protected $gatewayClient;

    public function __construct(ClientInterface $gatewayClient)
    {
        $this->gatewayClient = $gatewayClient;
    }

    protected function sendRequest(string $method, string $uri, array $options = []): ResponseInterface
    {
        if (!array_key_exists('http_errors', $options)) {
            $options['http_errors'] = false;
        }

        if (!array_key_exists('headers', $options)) {
            $options['headers'] = [];
        }

        if (!array_key_exists('accept', $options['headers'])) {
            $options['headers']['accept'] = 'groups=Detailed,CustomData';
        }

        return $this->gatewayClient->request($method, $uri, $options);
    }

    protected function getData(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    protected function handleErrors(ResponseInterface $response)
    {
        switch ($response->getStatusCode()) {
            case 400:
                $body = $response->getBody()->__toString();
                throw new ValidationException($body);
            case 401:
                throw new UnauthorizedException();
            case 404:
                throw new NotFoundException();
            default:
                throw new UnknownErrorException();
        }
    }
}
