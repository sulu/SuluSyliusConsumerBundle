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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\Message;

use Sulu\Bundle\RouteBundle\Model\RoutableInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\MissingResultException;

class PublishRoutableResourceMessage
{
    /**
     * @var string
     */
    private $resourceKey;

    /**
     * @var string
     */
    private $resourceId;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $routePath;

    /**
     * @var RoutableInterface|null
     */
    private $route;

    public function __construct(string $resourceKey, string $resourceId, string $locale, string $routePath)
    {
        $this->resourceKey = $resourceKey;
        $this->resourceId = $resourceId;
        $this->locale = $locale;
        $this->routePath = $routePath;
    }

    public function getResourceKey(): string
    {
        return $this->resourceKey;
    }

    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getRoutePath(): string
    {
        return $this->routePath;
    }

    public function getRoute(): RoutableInterface
    {
        if (!$this->route) {
            throw new MissingResultException(__METHOD__);
        }

        return $this->route;
    }

    public function setRoute(RoutableInterface $route): self
    {
        $this->route = $route;

        return $this;
    }
}
