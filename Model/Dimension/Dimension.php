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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Dimension;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Dimension implements DimensionInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Collection|DimensionAttributeInterface[]
     */
    private $attributes;

    /**
     * @var int
     */
    private $attributeCount;

    /**
     * @param DimensionAttributeInterface[] $attributes
     */
    public function __construct(string $id, array $attributes = [])
    {
        $this->id = $id;
        $this->attributes = new ArrayCollection($attributes);
        $this->attributeCount = $this->attributes->count();

        foreach ($this->attributes as $attribute) {
            $attribute->setDimension($this);
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAttributeCount(): int
    {
        return $this->attributeCount;
    }

    public function getAttributes(): array
    {
        return $this->attributes->getValues();
    }
}
