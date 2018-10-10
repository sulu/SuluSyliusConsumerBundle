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

class ContentRepository extends EntityRepository implements ContentRepositoryInterface
{
    public function findOrCreate(string $resourceKey, string $resourceId): ContentInterface
    {
        $content = $this->findByResource($resourceKey, $resourceId);
        if ($content) {
            return $content;
        }

        $className = $this->getClassName();
        $content = new $className($resourceKey, $resourceId);

        $this->getEntityManager()->persist($content);

        return $content;
    }

    public function findByResource(string $resourceKey, string $resourceId): ?ContentInterface
    {
        /** @var ContentInterface|null $content */
        $content = $this->find(['resourceKey' => $resourceKey, 'resourceId' => $resourceId]);

        return $content;
    }
}
