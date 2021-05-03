<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Payload;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ProductVariantPayload;
use Sulu\Bundle\SyliusConsumerBundle\Tests\MockSyliusData;

class ProductVariantPayloadTestPayloadTest extends TestCase
{
    public function testGetCode(): void
    {
        $entity = new ProductVariantPayload(MockSyliusData::PRODUCT_VARIANT['code'], 'product-1', MockSyliusData::PRODUCT_VARIANT);

        $this->assertEquals(MockSyliusData::PRODUCT_VARIANT['code'], $entity->getCode());
    }

    public function testGetProductCode(): void
    {
        $entity = new ProductVariantPayload(MockSyliusData::PRODUCT_VARIANT['code'], 'product-1', MockSyliusData::PRODUCT_VARIANT);

        $this->assertEquals('product-1', $entity->getProductCode());
    }

    public function testGetTranslations(): void
    {
        $entity = new ProductVariantPayload(MockSyliusData::PRODUCT_VARIANT['code'], 'product-1', MockSyliusData::PRODUCT_VARIANT);

        $translations = $entity->getTranslations();
        $this->assertCount(1, $translations);

        $this->assertEquals(MockSyliusData::PRODUCT_VARIANT['translations']['en_US'], $translations['en_us']->getPayload()->getData());
    }
}
