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

namespace Sulu\Bundle\SyliusConsumerBundle\Repository\RoutableResource;

use Doctrine\ORM\EntityRepository;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\RoutableResource\RoutableResourceRepositoryInterface;

class RoutableResourceRepository extends EntityRepository implements RoutableResourceRepositoryInterface
{
    public function findOrCreateByResource(
        string $resourceKey,
        string $resourceId,
        DimensionInterface $dimension
    ): RoutableResourceInterface {
        $routable = $this->findByResource($resourceKey, $resourceId, $dimension);
        if ($routable) {
            return $routable;
        }

        $className = $this->getClassName();
        $routable = new $className($dimension, $resourceKey, $resourceId);

        $this->getEntityManager()->persist($routable);

        return $routable;
    }

    public function findByResource(
        string $resourceKey,
        string $resourceId,
        DimensionInterface $dimension
    ): ?RoutableResourceInterface {
        /** @var RoutableResourceInterface|null $routable */
        $routable = $this->find(
            ['resourceKey' => $resourceKey, 'resourceId' => $resourceId, 'dimension' => $dimension]
        );

        return $routable;
    }
}
