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

interface DimensionInterface
{
    /**
     * @param DimensionAttributeInterface[] $attributes
     */
    public function __construct(string $id, array $attributes = []);

    public function getId(): string;

    public function getAttributeCount(): int;

    public function getAttributes();
}
