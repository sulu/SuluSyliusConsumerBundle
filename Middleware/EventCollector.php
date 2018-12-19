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

use Symfony\Component\EventDispatcher\Event;

class EventCollector
{
    /**
     * @var Event[][]
     */
    private $events = [];

    public function push(string $name, Event $event): void
    {
        if (!array_key_exists($name, $this->events)) {
            $this->events[$name] = [];
        }

        $this->events[$name][] = $event;
    }

    /**
     * @return Event[][]
     */
    public function release(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
