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
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformation;

trait ProductInformationTrait
{
    protected function createProductInformation(string $code, string $locale): ProductInformation
    {
        $dimension = $this->findDimension(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );

        $product = new ProductInformation($code, $dimension);

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();

        return $product;
    }

    protected function findProductInformation(string $code, string $locale): ?ProductInformation
    {
        $dimension = $this->findDimension(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );

        return $this->getEntityManager()->find(ProductInformation::class, ['code' => $code, 'dimension' => $dimension]);
    }

    abstract protected function findDimension(array $attributes): DimensionInterface;

    /**
     * @return EntityManagerInterface
     */
    abstract protected function getEntityManager();
}
