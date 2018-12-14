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

namespace Sulu\Bundle\SyliusConsumerBundle\Middleware;

use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventMiddleware implements MiddlewareInterface
{
    /**
     * @var EventCollector
     */
    private $eventCollector;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EventCollector $eventCollector, EventDispatcherInterface $eventDispatcher)
    {
        $this->eventCollector = $eventCollector;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle($message, callable $next)
    {
        $result = $next($message);

        foreach ($this->eventCollector->release() as $name => $events) {
            foreach ($events as $event) {
                $this->eventDispatcher->dispatch($name, $event);
            }
        }

        return $result;
    }
}