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

class DimensionAttribute implements DimensionAttributeInterface
{
    /**
     * @var DimensionInterface
     */
    private $dimension;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    public function __construct(string $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function setDimension(DimensionInterface $dimension): DimensionAttributeInterface
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function getDimension(): DimensionInterface
    {
        return $this->dimension;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
