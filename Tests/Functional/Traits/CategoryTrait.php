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

use Psr\Container\ContainerInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Category\CategoryRepositoryInterface;

trait CategoryTrait
{
    protected function findCategory(int $syliusId): ?CategoryInterface
    {
        /** @var CategoryRepositoryInterface $repository */
        $repository = $this->getContainer()->get('sulu.repository.category');
        return $repository->findBySyliusId($syliusId);
    }

    /**
     * @return ContainerInterface
     */
    abstract protected function getContainer();
}
