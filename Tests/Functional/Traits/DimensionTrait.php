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
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

trait DimensionTrait
{
    protected function findDimension(array $attributes): DimensionInterface
    {
        return $this->getContainer()->get('sulu_sylius_consumer_test.repository.dimension')
            ->findOrCreateByAttributes($attributes);
    }

    /**
     * @return ContainerInterface
     */
    abstract protected function getContainer();
}
