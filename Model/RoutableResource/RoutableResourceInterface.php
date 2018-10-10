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

use Sulu\Bundle\RouteBundle\Model\RoutableInterface as SuluRoutableInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

interface RoutableResourceInterface extends SuluRoutableInterface
{
    public function __construct(DimensionInterface $dimension, string $resourceKey, string $resourceId);

    public function getDimension(): DimensionInterface;

    public function getResourceKey(): string;

    public function getResourceId(): string;
}
