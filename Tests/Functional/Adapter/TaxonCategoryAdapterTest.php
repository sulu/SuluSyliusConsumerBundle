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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Adapter;

use Sulu\Bundle\SyliusConsumerBundle\Adapter\TaxonCategoryAdapter;
use Sulu\Bundle\SyliusConsumerBundle\Entity\TaxonCategoryBridge;
use Sulu\Bundle\SyliusConsumerBundle\Payload\TaxonPayload;
use Sulu\Bundle\SyliusConsumerBundle\Tests\MockSyliusData;
use Sulu\Bundle\TestBundle\Testing\KernelTestCase;
use Sulu\Bundle\TestBundle\Testing\PurgeDatabaseTrait;

class TaxonCategoryAdapterTest extends KernelTestCase
{
    use PurgeDatabaseTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->purgeDatabase();
    }

    public function testSynchronize(): void
    {
        $adapter = $this->getContainer()->get(TaxonCategoryAdapter::class);

        $taxonPayload = new TaxonPayload(1, MockSyliusData::TAXON);

        $adapter->synchronize($taxonPayload);

        // Adapter flushed the entity-manager - by clearing it we can check if that works correctly
        $this->getEntityManager()->clear();

        $bridge1 = $this->getEntityManager()->find(TaxonCategoryBridge::class, 1);
        $bridge2 = $this->getEntityManager()->find(TaxonCategoryBridge::class, 2);
        $bridge3 = $this->getEntityManager()->find(TaxonCategoryBridge::class, 3);

        $this->assertNotNull($bridge1);
        $this->assertNotNull($bridge2);
        $this->assertNotNull($bridge3);

        $category1 = $bridge1->getCategory();
        $category2 = $bridge2->getCategory();
        $category3 = $bridge3->getCategory();

        $this->assertEquals('MENU_CATEGORY', $category1->getKey());
        $this->assertEquals('t_shirts', $category2->getKey());
        $this->assertEquals('mens_t_shirts', $category3->getKey());

        $this->assertEquals('en_us', $category1->getDefaultLocale());
        $this->assertEquals('en_us', $category2->getDefaultLocale());
        $this->assertEquals('en_us', $category3->getDefaultLocale());

        $this->assertEquals('Category', $category1->findTranslationByLocale('en_us')->getTranslation());
        $this->assertEquals('T-shirts', $category2->findTranslationByLocale('en_us')->getTranslation());
        $this->assertEquals('necessitatibus optio labore', $category3->findTranslationByLocale('en_us')->getTranslation());

        $this->assertNull($category1->getParent());
        $this->assertEquals($category1->getId(), $category2->getParent()->getId());
        $this->assertEquals($category2->getId(), $category3->getParent()->getId());
    }
}
