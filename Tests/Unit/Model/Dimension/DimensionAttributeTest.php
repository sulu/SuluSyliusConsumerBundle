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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Model\Dimension;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionAttribute;
use Sulu\Bundle\SyliusConsumerBundle\Model\Dimension\DimensionInterface;

class DimensionAttributeTest extends TestCase
{
    public function testGetDimension(): void
    {
        $dimension = $this->prophesize(DimensionInterface::class);

        $attribute = new DimensionAttribute('workspace', 'draft');
        $this->assertEquals($attribute, $attribute->setDimension($dimension->reveal()));

        $this->assertEquals($dimension->reveal(), $attribute->getDimension());
    }

    public function testGetType(): void
    {
        $attribute = new DimensionAttribute('workspace', 'draft');

        $this->assertEquals('workspace', $attribute->getType());
    }

    public function testGetValue(): void
    {
        $attribute = new DimensionAttribute('workspace', 'draft');

        $this->assertEquals('draft', $attribute->getValue());
    }
}
