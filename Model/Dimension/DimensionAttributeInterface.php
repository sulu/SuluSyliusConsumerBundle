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

interface DimensionAttributeInterface
{
    public function __construct(string $key, string $value);

    public function setDimension(DimensionInterface $dimension): DimensionAttributeInterface;

    public function getDimension(): DimensionInterface;

    public function getKey(): string;

    public function getValue(): string;
}
