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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Content\Content;

trait ContentTrait
{
    protected function createContent(
        string $resourceKey,
        string $resourceId,
        ?string $type = 'default',
        array $data = ['title' => 'Sulu is awesome']
    ): Content {
        $content = new Content($resourceKey, $resourceId, $type, $data);

        $this->getEntityManager()->persist($content);
        $this->getEntityManager()->flush();

        return $content;
    }

    protected function findContent(string $resourceKey, string $resourceId): ?Content
    {
        /** @var Content $content */
        $content = $this->getEntityManager()->find(
            Content::class,
            ['resourceKey' => $resourceKey, 'resourceId' => $resourceId]
        );

        return $content;
    }

    /**
     * @return EntityManagerInterface
     */
    abstract protected function getEntityManager();
}
