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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\CategoryBundle\Entity\CategoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Entity\TaxonCategoryReference;

class TaxonCategoryReferenceTest extends TestCase
{
    public function testGetId(): void
    {
        $category = $this->prophesize(CategoryInterface::class);
        $entity = new TaxonCategoryReference(42, $category->reveal());

        $this->assertEquals(42, $entity->getTaxonId());
    }

    public function testGetCategory(): void
    {
        $category = $this->prophesize(CategoryInterface::class);
        $entity = new TaxonCategoryReference(42, $category->reveal());

        $this->assertEquals($category->reveal(), $entity->getCategory());
    }
}
