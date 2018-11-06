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

interface ProductInformationAttributeValueInterface
{
    public function getCode(): string;

    public function getType(): string;

    public function setValue($value): self;

    public function getValue();
}
