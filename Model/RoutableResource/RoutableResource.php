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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource;

use Sulu\Bundle\RouteBundle\Model\RouteInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

class RoutableResource implements RoutableResourceInterface
{
    /**
     * @var DimensionInterface
     */
    private $dimension;

    /**
     * @var string
     */
    private $resourceKey;

    /**
     * @var string
     */
    private $resourceId;

    /**
     * @var RouteInterface
     */
    private $route;

    public function __construct(DimensionInterface $dimension, string $resourceKey, string $resourceId)
    {
        $this->dimension = $dimension;
        $this->resourceKey = $resourceKey;
        $this->resourceId = $resourceId;
    }

    public function getDimension(): DimensionInterface
    {
        return $this->dimension;
    }

    public function getResourceKey(): string
    {
        return $this->resourceKey;
    }

    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    public function getId(): string
    {
        return $this->resourceId;
    }

    public function getRoute(): ?RouteInterface
    {
        return $this->route;
    }

    public function setRoute(RouteInterface $route)
    {
        $this->route = $route;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->dimension->getAttributeValue('locale');
    }
}
