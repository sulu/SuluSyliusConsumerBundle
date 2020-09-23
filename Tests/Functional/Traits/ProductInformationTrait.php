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
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductInformation;

trait ProductInformationTrait
{
    protected function createProductInformation(string $productId, string $locale): ProductInformation
    {
        $dimension = $this->findDimension(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );

        /** @var ProductInterface $product */
        $product = $this->getEntityManager()->find(Product::class, $productId);
        if (!$product instanceof ProductInterface) {
            throw new \RuntimeException('Product not fount');
        }

        $productInformation = new ProductInformation($product, $dimension);

        $this->getEntityManager()->persist($productInformation);

        $this->getEntityManager()->flush();

        return $productInformation;
    }

    protected function createProductInformationLive(string $productId, string $locale): ProductInformation
    {
        $dimension = $this->findDimension(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_LIVE,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );

        $product = $this->getEntityManager()->find(Product::class, $productId);
        if (!$product) {
            throw new \RuntimeException('Product not fount');
        }

        $productInformation = new ProductInformation($product, $dimension);

        $this->getEntityManager()->persist($productInformation);

        $this->getEntityManager()->flush();

        return $productInformation;
    }

    protected function findProductInformation(string $id, string $locale): ?ProductInformation
    {
        $dimension = $this->findDimension(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );

        return $this->getEntityManager()->find(
            ProductInformation::class,
            ['product' => $id, 'dimension' => $dimension]
        );
    }

    protected function findProductInformationByCode(string $code, string $locale): ?ProductInformation
    {
        $dimension = $this->findDimension(
            [
                DimensionInterface::ATTRIBUTE_KEY_STAGE => DimensionInterface::ATTRIBUTE_VALUE_DRAFT,
                DimensionInterface::ATTRIBUTE_KEY_LOCALE => $locale,
            ]
        );

        $product = $this->getEntityManager()->getRepository(Product::class)->findOneBy(['code' => $code]);
        if (!$product) {
            throw new \RuntimeException('Product not fount');
        }

        return $this->getEntityManager()->find(
            ProductInformation::class,
            [
                'product' => $product,
                'dimension' => $dimension,
            ]
        );
    }

    abstract protected function findDimension(array $attributes): DimensionInterface;

    /**
     * @return EntityManagerInterface
     */
    abstract protected function getEntityManager();
}
