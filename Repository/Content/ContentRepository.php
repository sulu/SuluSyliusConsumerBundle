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

namespace Sulu\Bundle\SyliusConsumerBundle\Repository\Content;

use Doctrine\ORM\EntityRepository;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\ContentRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

class ContentRepository extends EntityRepository implements ContentRepositoryInterface
{
    public function findOrCreate(
        string $resourceKey,
        string $resourceId,
        DimensionInterface $dimension
    ): ContentInterface {
        /** @var ContentInterface|null $content */
        $content = $this->findByResource($resourceKey, $resourceId, $dimension);
        if ($content) {
            return $content;
        }

        $className = $this->getClassName();
        $content = new $className($dimension, $resourceKey, $resourceId);

        $this->getEntityManager()->persist($content);

        return $content;
    }

    public function findByResource(
        string $resourceKey,
        string $resourceId,
        DimensionInterface $dimension
    ): ?ContentInterface {
        /** @var ContentInterface|null $content */
        $content = $this->find(['resourceKey' => $resourceKey, 'resourceId' => $resourceId, 'dimension' => $dimension]);

        return $content;
    }

    public function findByDimensions(string $resourceKey, string $resourceId, array $dimensions): array
    {
        return $this->findBy(['dimension' => $dimensions]);
    }
}
