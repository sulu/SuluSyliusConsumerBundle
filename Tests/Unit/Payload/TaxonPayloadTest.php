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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Payload;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Payload\TaxonPayload;
use Sulu\Bundle\SyliusConsumerBundle\Tests\MockSyliusData;

class TaxonPayloadTest extends TestCase
{
    public function testGetId(): void
    {
        $entity = new TaxonPayload(1, MockSyliusData::TAXON);

        $this->assertEquals(1, $entity->getId());
    }

    public function testGetCode(): void
    {
        $entity = new TaxonPayload(1, MockSyliusData::TAXON);

        $this->assertEquals(MockSyliusData::TAXON['code'], $entity->getCode());
    }

    public function testGetLevel(): void
    {
        $entity = new TaxonPayload(1, MockSyliusData::TAXON);

        $this->assertEquals(MockSyliusData::TAXON['level'], $entity->getLevel());
    }

    public function testGetPosition(): void
    {
        $entity = new TaxonPayload(1, MockSyliusData::TAXON);

        $this->assertEquals(MockSyliusData::TAXON['position'], $entity->getPosition());
    }

    public function testGetTranslations(): void
    {
        $entity = new TaxonPayload(1, MockSyliusData::TAXON);

        $translations = $entity->getTranslations();
        $this->assertCount(1, $translations);

        $this->assertEquals(MockSyliusData::TAXON['translations']['en_US'], $translations['en_US']->getPayload()->getData());
    }

    public function testGetChildren(): void
    {
        $entity = new TaxonPayload(1, MockSyliusData::TAXON);

        $children = $entity->getChildren();
        $this->assertCount(1, $children);

        $this->assertEquals(MockSyliusData::TAXON['children'][0], $children[0]->getPayload()->getData());
    }
}
