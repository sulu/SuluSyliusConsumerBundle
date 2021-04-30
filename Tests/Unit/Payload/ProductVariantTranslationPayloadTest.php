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
use Sulu\Bundle\SyliusConsumerBundle\Payload\ProductVariantTranslationPayload;
use Sulu\Bundle\SyliusConsumerBundle\Tests\MockSyliusData;
use Sulu\Component\Localization\Localization;

class ProductVariantTranslationPayloadTest extends TestCase
{
    public function testGetLocale(): void
    {
        $entity = new ProductVariantTranslationPayload(MockSyliusData::PRODUCT_VARIANT['translations']['en_US']);

        $this->assertEquals('en_us', $entity->getLocale());
    }

    public function testGetLocalization(): void
    {
        $entity = new ProductVariantTranslationPayload(MockSyliusData::PRODUCT_VARIANT['translations']['en_US']);

        $this->assertInstanceOf(Localization::class, $entity->getLocalization());
        $this->assertEquals('en_us', $entity->getLocalization()->getLocale());
    }

    public function testGetName(): void
    {
        $entity = new ProductVariantTranslationPayload(MockSyliusData::PRODUCT_VARIANT['translations']['en_US']);

        $this->assertEquals('S', $entity->getName());
    }
}
