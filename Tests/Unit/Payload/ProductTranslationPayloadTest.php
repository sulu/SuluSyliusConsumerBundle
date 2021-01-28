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
use Sulu\Bundle\SyliusConsumerBundle\Payload\ProductTranslationPayload;
use Sulu\Bundle\SyliusConsumerBundle\Tests\MockSyliusData;
use Sulu\Component\Localization\Localization;

class ProductTranslationPayloadTest extends TestCase
{
    public function testGetLocale(): void
    {
        $entity = new ProductTranslationPayload(MockSyliusData::PRODUCT['translations'][0]);

        $this->assertEquals('en_us', $entity->getLocale());
    }

    public function testGetLocalization(): void
    {
        $entity = new ProductTranslationPayload(MockSyliusData::PRODUCT['translations'][0]);

        $this->assertInstanceOf(Localization::class, $entity->getLocalization());
        $this->assertEquals('en_us', $entity->getLocalization()->getLocale());
    }

    public function testGetName(): void
    {
        $entity = new ProductTranslationPayload(MockSyliusData::PRODUCT['translations'][0]);

        $this->assertEquals('Everyday white basic T-Shirt', $entity->getName());
    }

    public function testGetSlug(): void
    {
        $entity = new ProductTranslationPayload(MockSyliusData::PRODUCT['translations'][0]);

        $this->assertEquals('everyday-white-basic-t-shirt', $entity->getSlug());
    }

    public function testGetDescription(): void
    {
        $entity = new ProductTranslationPayload(MockSyliusData::PRODUCT['translations'][0]);

        $this->assertEquals('Quia nihil dignissimos expedita quia neque odio qui sunt. Nemo animi maxime rem qui quaerat eos. Eum ipsam aut aliquid cum et in sint.' . PHP_EOL . PHP_EOL . 'Est cumque illum saepe aliquam est. Ullam impedit ipsa aut nostrum est sunt nesciunt. Ut sint saepe ullam sed dolorum atque eos accusamus.' . PHP_EOL . PHP_EOL . 'Expedita voluptatum magnam est vitae voluptas eos. Maiores voluptatibus quos enim expedita voluptatibus aut. Non ducimus nesciunt voluptas deleniti.', $entity->getDescription());
    }

    public function testGetShortDescription(): void
    {
        $entity = new ProductTranslationPayload(MockSyliusData::PRODUCT['translations'][0]);

        $this->assertEquals('Sequi doloribus minus quis quibusdam. Architecto optio sit inventore quibusdam magni voluptatem. Non sed ex mollitia nisi nemo velit quidem.', $entity->getShortDescription());
    }

    public function testGetMetaKeyword(): void
    {
        $entity = new ProductTranslationPayload(MockSyliusData::PRODUCT['translations'][0]);

        $this->assertNull($entity->getMetaKeywords());
    }

    public function testGetMetaDescription(): void
    {
        $entity = new ProductTranslationPayload(MockSyliusData::PRODUCT['translations'][0]);

        $this->assertNull($entity->getMetaDescription());
    }
}
