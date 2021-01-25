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
use Sulu\Bundle\SyliusConsumerBundle\Payload\TaxonTranslationPayload;
use Sulu\Bundle\SyliusConsumerBundle\Tests\MockSyliusData;
use Sulu\Component\Localization\Localization;

class TaxonTranslationPayloadTest extends TestCase
{
    public function testGetId(): void
    {
        $entity = new TaxonTranslationPayload(1, MockSyliusData::TAXON['translations']['en_US']);

        $this->assertEquals(1, $entity->getId());
    }

    public function testGetLocale(): void
    {
        $entity = new TaxonTranslationPayload(1, MockSyliusData::TAXON['translations']['en_US']);

        $this->assertEquals('en_us', $entity->getLocale());
    }

    public function testGetLocalization(): void
    {
        $entity = new TaxonTranslationPayload(1, MockSyliusData::TAXON['translations']['en_US']);

        $this->assertInstanceOf(Localization::class, $entity->getLocalization());
        $this->assertEquals('en_us', $entity->getLocalization()->getLocale());
    }

    public function testGetName(): void
    {
        $entity = new TaxonTranslationPayload(1, MockSyliusData::TAXON['translations']['en_US']);

        $this->assertEquals('Category', $entity->getName());
    }

    public function testGetSlug(): void
    {
        $entity = new TaxonTranslationPayload(1, MockSyliusData::TAXON['translations']['en_US']);

        $this->assertEquals('category', $entity->getSlug());
    }

    public function testGetDescription(): void
    {
        $entity = new TaxonTranslationPayload(1, MockSyliusData::TAXON['translations']['en_US']);

        $this->assertEquals('Soluta deleniti dolore tenetur. Odio voluptatibus excepturi quas autem totam odio dolorum. Sed aut at cum quia recusandae. Quos eos iusto sed sed occaecati.', $entity->getDescription());
    }
}
