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

namespace Sulu\Bundle\SyliusConsumerBundle\Repository\Dimension;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Ramsey\Uuid\Uuid;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\Dimension;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionAttribute;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionRepositoryInterface;

class DimensionRepository extends EntityRepository implements DimensionRepositoryInterface
{
    /**
     * @var DimensionInterface[]
     */
    private $cachedEntities = [];

    public function create(array $attributes = []): DimensionInterface
    {
        $key = md5(serialize($attributes));
        if (array_key_exists($key, $this->cachedEntities)) {
            return $this->cachedEntities[$key];
        }

        $attributeEntities = [];
        foreach ($attributes as $type => $value) {
            $attributeEntities[] = $attributeEntity = new DimensionAttribute($type, $value);
        }

        $dimension = new Dimension(Uuid::uuid4()->toString(), $attributeEntities);
        $this->getEntityManager()->persist($dimension);

        return $this->cachedEntities[$key] = $dimension;
    }

    public function findOrCreateByAttributes(array $attributes): DimensionInterface
    {
        $dimension = $this->findOneByAttributes($attributes);
        if ($dimension) {
            return $dimension;
        }

        return $this->create($attributes);
    }

    protected function findOneByAttributes(array $attributes): ?DimensionInterface
    {
        $queryBuilder = $this->createQueryBuilder('dimension')
            ->where('dimension.attributeCount = ' . count($attributes));

        foreach ($attributes as $key => $value) {
            $queryBuilder->join('dimension.attributes', $key)
                ->andWhere($key . '.value = :' . $key . 'Value')
                ->andWhere($key . '.key = :' . $key . 'Key')
                ->setParameter($key . 'Key', $key)
                ->setParameter($key . 'Value', $value);
        }

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
