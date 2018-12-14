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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Service;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

class GatewayClient implements ClientInterface
{
    /**
     * @var callable
     */
    private $handleRequestCallable;

    public function setHandleRequestCallable(callable $handleRequestCallable)
    {
        $this->handleRequestCallable = $handleRequestCallable;
    }

    public function request($method, $uri, array $options = [])
    {
        if (!$this->handleRequestCallable) {
            throw new \RuntimeException('No mock given');
        }

        $callable = $this->handleRequestCallable;
        return $callable($method, $uri, $options);
    }

    public function send(RequestInterface $request, array $options = [])
    {
        throw new \RuntimeException('Not implemented');
    }

    public function sendAsync(RequestInterface $request, array $options = [])
    {
        throw new \RuntimeException('Not implemented');
    }

    public function requestAsync($method, $uri, array $options = [])
    {
        throw new \RuntimeException('Not implemented');
    }

    public function getConfig($option = null)
    {
        throw new \RuntimeException('Not implemented');
    }
}