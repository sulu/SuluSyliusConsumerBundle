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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Routable\Handler\Message;

use Sulu\Bundle\RouteBundle\Manager\RouteManagerInterface;
use Sulu\Bundle\RouteBundle\Model\RoutableInterface;
use Sulu\Bundle\RouteBundle\Model\RouteInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\Message\PublishRoutableMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\Routable\RoutableRepositoryInterface;

class PublishRoutableMessageHandler
{
    /**
     * @var RoutableRepositoryInterface
     */
    private $routableRepository;

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    /**
     * @var RouteManagerInterface
     */
    private $routeManager;

    public function __construct(
        RoutableRepositoryInterface $routableRepository,
        DimensionRepositoryInterface $dimensionRepository,
        RouteManagerInterface $routeManager
    ) {
        $this->routableRepository = $routableRepository;
        $this->dimensionRepository = $dimensionRepository;
        $this->routeManager = $routeManager;
    }

    public function __invoke(PublishRoutableMessage $message): RoutableInterface
    {
        $dimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $message->getLocale(),
            ]
        );

        $routable = $this->routableRepository->findOrCreateByResource(
            $message->getResourceKey(),
            $message->getResourceId(),
            $dimension
        );

        /** @var RouteInterface|null $route */
        $route = $routable->getRoute();
        if ($route) {
            $this->routeManager->update($routable, $message->getRoutePath());

            return $routable;
        }

        $this->routeManager->create($routable, $message->getRoutePath());

        return $routable;
    }
}
