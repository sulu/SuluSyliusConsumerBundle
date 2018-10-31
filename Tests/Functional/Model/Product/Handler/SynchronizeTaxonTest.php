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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Model\Product\Handler;

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Message\SynchronizeTaxonMessage;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\CategoryTrait;
use Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Traits\DimensionTrait;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class SynchronizeTaxonTest extends SuluTestCase
{
    use DimensionTrait;
    use CategoryTrait;

    public function setUp()
    {
        $this->purgeDatabase();
    }

    public function testSynchronizeProductCreate()
    {
        $message = new SynchronizeTaxonMessage(
            ExampleSynchronizeTaxonMessage::getCode(),
            ExampleSynchronizeTaxonMessage::getPayload()
        );

        /** @var MessageBusInterface $messageBus */
        $messageBus = $this->getContainer()->get('sulu_sylius_consumer_test.messenger.bus.default');

        $messageBus->dispatch($message);

        $this->getEntityManager()->clear();

        $category = $this->findCategory(ExampleSynchronizeTaxonMessage::getCode());
        $this->assertNotNull($category);
        if (!$category) {
            return;
        }

        $this->assertEquals('category', $category->getKey());
        $this->assertEquals(0, $category->getDepth());
        $this->assertEquals(1, $category->getLft());
        $this->assertEquals(14, $category->getRgt());
        $this->assertCount(2, $category->getTranslations());
        $this->assertCount(4, $category->getChildren());

        $translationDe = $category->findTranslationByLocale('de');
        $this->assertEquals('Kategorie', $translationDe->getTranslation());
        $this->assertEquals('Deutsche coole Beschreibung', $translationDe->getDescription());

        $translationEn = $category->findTranslationByLocale('en');
        $this->assertEquals('Category', $translationEn->getTranslation());
        $this->assertEquals('', $translationEn->getDescription());
    }
}
