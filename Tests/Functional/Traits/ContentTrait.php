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
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

trait ContentTrait
{
    use DimensionTrait;

    protected function createContent(
        string $resourceKey,
        string $resourceId,
        string $locale = 'en',
        ?string $type = 'default',
        array $data = ['title' => 'Sulu', 'article' => 'Sulu is awesome']
    ): Content {
        $dimension = $this->findDimension(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );
        $content = new Content($dimension, $resourceKey, $resourceId, $type, $data);

        $this->getEntityManager()->persist($content);
        $this->getEntityManager()->flush();

        return $content;
    }

    protected function findContent(string $resourceKey, string $resourceId, string $locale): ?Content
    {
        $dimension = $this->findDimension(['workspace' => 'draft', 'locale' => $locale]);

        /** @var Content $content */
        $content = $this->getEntityManager()->find(
            Content::class,
            ['resourceKey' => $resourceKey, 'resourceId' => $resourceId, 'dimension' => $dimension]
        );

        return $content;
    }

    /**
     * @return EntityManagerInterface
     */
    abstract protected function getEntityManager();
}
