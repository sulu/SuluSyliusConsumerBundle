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

namespace Sulu\Bundle\SyliusConsumerBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;

trait FindScheduldedEntityInsertionTrait
{
    /**
     * @return object|null
     */
    private function findScheduldedEntityInsertion(callable $callback)
    {
        foreach ($this->getEntityManager()->getUnitOfWork()->getScheduledEntityInsertions() as $scheduledEntityInsertion) {
            if (!is_a($scheduledEntityInsertion, $this->getClassName())) {
                continue;
            }

            if ($callback($scheduledEntityInsertion)) {
                return $scheduledEntityInsertion;
            }
        }

        return null;
    }

    /**
     * @return EntityManagerInterface
     */
    abstract public function getEntityManager();

    /**
     * @return string
     */
    abstract public function getClassName();
}
