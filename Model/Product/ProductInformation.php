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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

class ProductInformation implements ProductInformationInterface
{
    /**
     * @var DimensionInterface
     */
    private $dimension;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var Collection|ProductInformationVariantInterface[]
     */
    private $variants;

    public function __construct(string $code, DimensionInterface $dimension, array $variants = [])
    {
        $this->dimension = $dimension;
        $this->code = $code;

        $this->variants = new ArrayCollection($variants);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDimension(): DimensionInterface
    {
        return $this->dimension;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ProductInformationInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getVariants(): array
    {
        return $this->variants->getValues();
    }

    public function findVariantByCode(string $code): ?ProductInformationVariantInterface
    {
        if (!$this->variants->containsKey($code)) {
            return null;
        }

        return $this->variants->get($code);
    }

    public function addVariant(ProductInformationVariantInterface $variant): ProductInformationInterface
    {
        $this->variants->set($variant->getCode(), $variant);

        return $this;
    }

    public function removeVariant(ProductInformationVariantInterface $variant): ProductInformationInterface
    {
        $this->variants->remove($variant->getCode());

        return $this;
    }
}
