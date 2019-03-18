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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\Handler\Message;

use Sulu\Bundle\RouteBundle\Manager\RouteManagerInterface;
use Sulu\Bundle\RouteBundle\Model\RouteInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\Message\PublishRoutableResourceMessage;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceRepositoryInterface;

class PublishRoutableResourceMessageHandler
{
    /**
     * @var RoutableResourceRepositoryInterface
     */
    private $routableResourceRepository;

    /**
     * @var DimensionRepositoryInterface
     */
    private $dimensionRepository;

    /**
     * @var RouteManagerInterface
     */
    private $routeManager;

    public function __construct(
        RoutableResourceRepositoryInterface $routableResourceRepository,
        DimensionRepositoryInterface $dimensionRepository,
        RouteManagerInterface $routeManager
    ) {
        $this->routableResourceRepository = $routableResourceRepository;
        $this->dimensionRepository = $dimensionRepository;
        $this->routeManager = $routeManager;
    }

    public function __invoke(PublishRoutableResourceMessage $message): void
    {
        $dimension = $this->dimensionRepository->findOrCreateByAttributes(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $message->getLocale(),
            ]
        );

        $routableResource = $this->routableResourceRepository->findOrCreateByResource(
            $message->getResourceKey(),
            $message->getResourceId(),
            $dimension
        );

        /** @var RouteInterface|null $route */
        $route = $routableResource->getRoute();
        if ($route) {
            $this->routeManager->update($routableResource, $message->getRoutePath());

            $message->setRoute($routableResource);

            return;
        }

        $this->routeManager->create($routableResource, $message->getRoutePath());

        $message->setRoute($routableResource);
    }
}
