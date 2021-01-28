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
use Sulu\Bundle\SyliusConsumerBundle\Payload\ProductPayload;
use Sulu\Bundle\SyliusConsumerBundle\Tests\MockSyliusData;

class ProductPayloadTest extends TestCase
{
    public function testGetCode(): void
    {
        $entity = new ProductPayload(MockSyliusData::PRODUCT['code'], MockSyliusData::PRODUCT);

        $this->assertEquals(MockSyliusData::PRODUCT['code'], $entity->getCode());
    }

    public function testIsEnabled(): void
    {
        $entity = new ProductPayload(MockSyliusData::PRODUCT['code'], MockSyliusData::PRODUCT);

        $this->assertTrue($entity->isEnabled());
    }

    public function testGetMainTaxonId(): void
    {
        $entity = new ProductPayload(MockSyliusData::PRODUCT['code'], MockSyliusData::PRODUCT);

        $this->assertEquals(MockSyliusData::PRODUCT['mainTaxonId'], $entity->getMainTaxonId());
    }

    public function testGetTaxonIds(): void
    {
        $entity = new ProductPayload(MockSyliusData::PRODUCT['code'], MockSyliusData::PRODUCT);

        $this->assertEquals([2, 4], $entity->getTaxonIds());
    }

    public function testGetTranslations(): void
    {
        $entity = new ProductPayload(MockSyliusData::PRODUCT['code'], MockSyliusData::PRODUCT);

        $translations = $entity->getTranslations();
        $this->assertCount(1, $translations);

        $this->assertEquals(MockSyliusData::PRODUCT['translations'][0], $translations['en_us']->getPayload()->getData());
    }

    public function testGetVariants(): void
    {
        $entity = new ProductPayload(MockSyliusData::PRODUCT['code'], MockSyliusData::PRODUCT);

        $variants = $entity->getVariants();
        $this->assertCount(1, $variants);

        $this->assertEquals(MockSyliusData::PRODUCT['variants'][0], $variants[0]->getPayload()->getData());
    }
}
